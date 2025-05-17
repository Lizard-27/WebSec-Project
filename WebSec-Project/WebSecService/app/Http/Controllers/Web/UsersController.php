<?php
namespace App\Http\Controllers\Web;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Artisan;

use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller {

    use ValidatesRequests;


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }


    public function handleFacebookCallback()
    {

        $userfacebook = Socialite::driver('facebook')->user();


        $user = User::firstOrCreate(
            ['facebook_id' => $userfacebook->getId()],
            [
                'facebook_name' => $userfacebook->getName(),
                'facebook_email' => $userfacebook->getEmail(),
            ]
        );

        Auth::login($user);
    }


    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    /** Handle GitHub callback */
    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            // Find or create user
            $user = User::firstOrCreate(
                ['email' => $githubUser->getEmail()],
                [
                    'name'     => $githubUser->getName() ?? $githubUser->getNickname(),
                    'password' => bcrypt(Str::random(24)),
                ]
            );

            Auth::login($user);

            return redirect('/')->with('status', 'Logged in with GitHub!');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('GitHub login failed.');
        }
    }


    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /** Handle callback from Twitter */
    public function handleTwitterCallback()
    {
        try {
            $twitterUser = Socialite::driver('twitter')->user();

            // Note: Twitter may not provide email by default.
            // If you require email, ensure you have permission and Twitter API configured.

            // Find or create the user
            $user = User::firstOrCreate(
                ['email' => $twitterUser->getEmail() ?? 'twitter_'.$twitterUser->getId().'@example.com'],
                [
                    'name'     => $twitterUser->getName() ?? $twitterUser->getNickname(),
                    'password' => bcrypt(Str::random(24)),
                ]
            );

            Auth::login($user);

            return redirect('/')->with('status', 'Logged in with Twitter!');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Twitter login failed: '.$e->getMessage());
        }
    }

public function redirectToGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate([
            'email' => $googleUser->getEmail(),
        ], [
            'name' => $googleUser->getName(),
            'password' => bcrypt(Str::random(16)),
        ]);

        Auth::login($user);

        return redirect('/');

    } catch (\Exception $e) {
        return redirect('/login')->withErrors(['msg' => 'Google login failed.']);
    }
}


    public function list(Request $request) {
        if(!auth()->user()->hasPermissionTo('show_users'))abort(401);
        $query = User::select('*');
        $query->when($request->keywords,
        fn($q)=> $q->where("name", "like", "%$request->keywords%"));
        $users = $query->get();
        return view('users.list', compact('users'));
    }

    public function register(Request $request) {
        return view('users.register');
    }

    public function doRegister(Request $request) {

        try {
            $this->validate($request, [
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        }
        catch(\Exception $e) {

            return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
        }


        $user =  new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); //Secure
        $user->save();

        return redirect('/');
    }

    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request) {

        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

        $user = User::where('email', $request->email)->first();
        Auth::setUser($user);

        return redirect('/');
    }

    public function doLogout(Request $request) {

        Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = [];
        foreach(Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach(Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user) {

        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if(auth()->user()->hasPermissionTo('admin_users')) {

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }

        //$user->syncRoles([1]);
        //Artisan::call('cache:clear');

        return redirect(route('profile', ['user'=>$user->id]));
    }

    public function delete(Request $request, User $user) {

        if(!auth()->user()->hasPermissionTo('delete_users')) abort(401);

        //$user->delete();

        return redirect()->route('users');
    }

    public function editPassword(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user?->id) {
            if(!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user) {

        if(auth()->id()==$user?->id) {

            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if(!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {

                Auth::logout();
                return redirect('/');
            }
        }
        else if(!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); //Secure
        $user->save();

        return redirect(route('profile', ['user'=>$user->id]));
    }


    public function addRole(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('admin_users')) abort(401);

        // Get all available permissions
        $permissions = Permission::all();

        return view('users.add_role', compact('user', 'permissions'));
    }

    public function saveRole(Request $request, User $user)
    {
        if (!auth()->user()->hasPermissionTo('admin_users')) abort(401);

        $this->validate($request, [
            'role_name' => ['required', 'string', 'unique:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,name']
        ]);

        // Create the new role
        $role = Role::create(['name' => $request->role_name]);

        // Assign permissions to the role
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        // Assign the role to the user
        $user->assignRole($role);

        return redirect(route('profile', ['user' => $user->id]))->with('success', 'New role created and assigned successfully');
    }

}
