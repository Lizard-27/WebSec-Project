<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\DeliveryController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\FinanceController;
use App\Http\Controllers\Web\WelcomeController; // Add this at the top if not present

/*
|--------------------------------------------------------------------------
| User & Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login',    [UsersController::class, 'login'])->name('login');
Route::post('login',   [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout',   [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
// Route::get('/', [HomeController::class, 'index'])->name('home'); // Remove or comment out this line

// Forgot password
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset password
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Social logins
Route::get('auth/google',      [UsersController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [UsersController::class, 'handleGoogleCallback']);
Route::get('auth/twitter',     [UsersController::class, 'redirectToTwitter'])->name('auth.twitter');
Route::get('auth/twitter/callback', [UsersController::class, 'handleTwitterCallback']);
Route::get('auth/github',      [UsersController::class, 'redirectToGitHub'])->name('auth.github');
Route::get('auth/github/callback', [UsersController::class, 'handleGitHubCallback']);
Route::get('auth/facebook',    [UsersController::class, 'redirectToFacebook'])->name('redirectToFacebook');
Route::get('auth/facebook/callback', [UsersController::class, 'handleFacebookCallback'])->name('handleFacebookCallback');



Route::get('finance', [FinanceController::class, 'index'])
    ->middleware('auth:web')
    ->name('finance');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
// Show “please verify” notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Handle the verification link the user clicks
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();  // marks email_verified_at
    return redirect()->route('profile', $request->user()->id)
        ->with('status', 'verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend the verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| User Management
|--------------------------------------------------------------------------
*/
Route::get('users',             [UsersController::class, 'list'])->name('users');
Route::get('profile/{user?}',   [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::get('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('/users/{user}/add-role', [UsersController::class, 'addRole'])->name('users_add_role');
Route::post('/users/{user}/add-role', [UsersController::class, 'saveRole'])->name('users_add_role');

/*
|--------------------------------------------------------------------------
| Product Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');



// 4️⃣ Purchase history – must come before products/{product}
Route::get('my-purchases', [ProductsController::class, 'myProducts'])
    ->middleware('auth:web')
    ->name('my_purchases');

// 1️⃣ Product catalog
Route::get('products', [ProductsController::class, 'list'])
    ->name('products_list');

// ★ Create form (static)
Route::get('products/create', [ProductsController::class, 'edit'])
    ->middleware('auth:web')
    ->name('products_create');

// ★ Edit form (static)
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])
    ->middleware('auth:web')
    ->name('products_edit');

// ★ Save (static)
Route::post('products/save/{product?}', [ProductsController::class, 'save'])
    ->middleware('auth:web')
    ->name('products_save');

// ★ Delete (static)
Route::get('products/delete/{product}', [ProductsController::class, 'delete'])
    ->middleware('auth:web')
    ->name('products_delete');

// 2️⃣ Now your dynamic routes
// Show dish detail + rating form
Route::get('products/{product}', [ProductsController::class, 'show'])
    ->middleware('auth:web')
    ->name('products.show');

// Submit a rating
Route::post('products/{product}/rate', [ProductsController::class, 'rate'])
    ->middleware('auth:web')
    ->name('products.rate');

// Purchase
Route::post('products/{product}/purchase', [ProductsController::class, 'purchase'])
    ->middleware('auth:web')
    ->name('products.purchase');


/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('cart',                   [CartController::class, 'index'])->name('cart.index');
    Route::post('cart/add/{product}',    [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/item/{item}/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('cart/item/{item}',    [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/checkout',         [CartController::class, 'checkout'])->name('cart.checkout');
});

/*
|--------------------------------------------------------------------------
| OIDC discovery document & JWKS & Callback
|--------------------------------------------------------------------------
*/
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

Route::get('/oauth/jwks', function () {
    $key = trim(file_get_contents(storage_path('oauth-public.key')));
    $jwk = \Firebase\JWT\JWK::parseKeySet(['keys' => [\Firebase\JWT\JWT::parseKey($key)]]);
    return response()->json($jwk);
});

Route::get('/callback', function (Request $request) {
    return response()->json($request->all());
});

/*
|--------------------------------------------------------------------------
| Delivery Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('delivery')
    ->name('delivery.')
    ->group(function () {
        Route::get('/',                [DeliveryController::class, 'index'])->name('index');
        Route::post('{order}/accept',  [DeliveryController::class, 'accept'])->name('accept');
        Route::get('{order}',          [DeliveryController::class, 'show'])->name('show');
        Route::post('{order}/confirm', [DeliveryController::class, 'confirm'])->name('confirm');
    });
