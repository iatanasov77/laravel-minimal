<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Common Routes
 */
Route::get( '/file/{fileId}', 'FileManagerController@show' )->name( 'app.file-manager.show' );
Route::get( '/', function () 
{
    return Auth::check() ? Redirect::to( Config::get( 'auth.app.home' ) )
                        : Redirect::to( Config::get( 'auth.app.login' ) ); 
});

/*
 * Auth routes
 */
Route::get( '/login', 'AuthController@showLoginForm' )
    ->name( 'app.auth.form' )
    ->middleware( 'guest:app' );

Route::post( '/login', 'AuthController@login' )
    ->name( 'app.auth.login' );

Route::get( '/logout', 'AuthController@logout' )
    ->name( 'app.auth.logout' );

Route::get( '/register', 'RegistrationController@showForm' )
    ->name( 'app.registration.show-form' );

Route::post( '/register', 'RegistrationController@submitForm' )
    ->name( 'app.registration.submit-form' );
    
/*
 * Routes required authentication
 */ 
Route::group( ['middleware' => ['auth:app']], function()
{
    Route::get( '/profile', 'ProfileController@showForm' )
        ->name( 'app.profile.show-form' );
    Route::post( '/profile', 'ProfileController@submitForm' )
        ->name( 'app.profile.submit-form' );
    
    Route::resource( 'users', '\App\Resources\Controllers\UsersController', [ 'as' => 'resources'] );
});
