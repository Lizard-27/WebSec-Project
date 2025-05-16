<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\CartController;

/*
|--------------------------------------------------------------------------
| User & Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login',    [UsersController::class, 'login'])     ->name('login');
Route::post('login',   [UsersController::class, 'doLogin'])   ->name('do_login');
Route::get('logout',   [UsersController::class, 'doLogout'])  ->name('do_logout');

// Social logins
Route::get('auth/google',   [UsersController::class, 'redirectToGoogle'])  ->name('auth.google');
Route::get('auth/google/callback', [UsersController::class, 'handleGoogleCallback']);
Route::get('auth/twitter',  [UsersController::class, 'redirectToTwitter']) ->name('auth.twitter');
Route::get('auth/twitter/callback', [UsersController::class, 'handleTwitterCallback']);
Route::get('auth/github',   [UsersController::class, 'redirectToGitHub'])  ->name('auth.github');
Route::get('auth/github/callback', [UsersController::class, 'handleGitHubCallback']);
Route::get('auth/facebook', [UsersController::class, 'redirectToFacebook'])->name('redirectToFacebook');
Route::get('auth/facebook/callback', [UsersController::class, 'handleFacebookCallback'])->name('handleFacebookCallback');

/*
|--------------------------------------------------------------------------
| User Management
|--------------------------------------------------------------------------
*/
Route::get('users',        [UsersController::class, 'list'])        ->name('users');
Route::get('profile/{user?}', [UsersController::class, 'profile']) ->name('profile');
Route::get('users/edit/{user?}',  [UsersController::class, 'edit'])       ->name('users_edit');
Route::post('users/save/{user}',  [UsersController::class, 'save'])       ->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])     ->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword']) ->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword']) ->name('save_password');
Route::get('/users/{user}/add-role', [UsersController::class, 'addRole'])->name('users_add_role');
Route::post('/users/{user}/add-role', [UsersController::class, 'saveRole'])->name('users_add_role');

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function() {
    return view('welcome');
});

// 1️⃣ Product catalog
Route::get('products', [ProductsController::class, 'list'])
     ->name('products_list');

// 2️⃣ Product details & purchase form
Route::get('products/{id}', [ProductsController::class, 'show'])
     ->name('products.show')
     ->middleware('auth');

// 3️⃣ Handle purchase submission
Route::post('products/{id}/purchase', [ProductsController::class, 'purchase'])
     ->name('products.purchase')
     ->middleware('auth');

// 4️⃣ Purchase history
Route::get('my-purchases', [ProductsController::class, 'myProducts'])
     ->name('my_purchases')
     ->middleware('auth');

// 5️⃣ Admin: add/edit/delete products
Route::get('products/create', [ProductsController::class, 'edit'])
     ->name('products_create');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])
     ->name('products_edit')
     ->middleware('auth');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])
     ->name('products_save')
     ->middleware('auth');
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])
     ->name('products_delete')
     ->middleware('auth');



Route::middleware('auth')->group(function(){
    Route::get('cart', [CartController::class,'index'])->name('cart.index');
    Route::post('cart/add/{product}', [CartController::class,'add'])->name('cart.add');
    Route::post('cart/item/{item}/update', [CartController::class,'update'])->name('cart.update');
    Route::delete('cart/item/{item}', [CartController::class,'remove'])->name('cart.remove');
    Route::post('cart/checkout', [CartController::class,'checkout'])
         ->name('cart.checkout');
    Route::get('cart', [CartController::class,'index'])
         ->name('cart.index');
});





// OIDC discovery document
Route::get('/.well-known/openid-configuration', function () {
    $base = url('/');
    return response()->json([
        'issuer'                             => $base,
        'authorization_endpoint'            => $base . '/oauth/authorize',
        'token_endpoint'                    => $base . '/oauth/token',
        'jwks_uri'                          => $base . '/oauth/jwks',
        'response_types_supported'          => ['code', 'token', 'id_token'],
        'subject_types_supported'           => ['public'],
        'id_token_signing_alg_values_supported' => ['RS256'],
        'scopes_supported'                  => ['openid', 'profile', 'email'],
    ]);
});

// JWKS (public keys) endpoint
Route::get('/oauth/jwks', function () {
    $key = trim(file_get_contents(storage_path('oauth-public.key')));
    $jwk = \Firebase\JWT\JWK::parseKeySet(['keys' => [\Firebase\JWT\JWT::parseKey($key)]]);
    return response()->json($jwk);
});

Route::get('/callback', function (Request $request) {
    // Dump out everything so you can see the `code` parameter
    return response()->json($request->all());
});



/*
|--------------------------------------------------------------------------
| Misc Pages
|--------------------------------------------------------------------------
*/
Route::get('/multable', function(Request $request) {
    $j = $request->number ?? 5;
    $msg = $request->msg;
    return view('multable', compact('j','msg'));
});
Route::get('/even', function() { return view('even'); });
Route::get('/prime', function() { return view('prime'); });
Route::get('/test', function()  { return view('test'); });
