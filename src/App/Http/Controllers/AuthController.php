<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;

/**
 * @brief Authentication Controller
 *
 * @author Ivan Atanasov
 */
class AuthController extends BaseController
{
    /**
     * @brief   Auth guard instance
     *
     * @var     \Illuminate\Contracts\Auth\StatefulGuard $guard
     */
    private $guard;
    
    /**
     * @brief   Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->guard    = Auth::guard( 'app' );
    }
    
    /**
     *  @brief  Show The login form
     *  
     *  @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return View::make( 'app.login' );
    }
    
    /**
     * @brief   Login action
     *
     * @var \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login( Request $request )
    {
        $credentials    = $request->only( 'email', 'password' );
        $remember       = $request->has( 'rememberme' );
        
        $logged         = $this->guard->attempt( $credentials, $remember );
        if ( $logged )
        {
            return Redirect::intended( Config::get( 'auth.app.home' ) );
        }
        
        // Login Error
        $request->session()->flash( 'loginError', 'Invalid username or password' );
        return Redirect::to( Config::get( 'auth.app.login' ) );
    }
    
    /**
     * @brief  Logout action
     *
     * @var \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout( Request $request )
    {
        $this->guard->logout();
        
        $request->session()->invalidate();
        
        return Redirect::to( Config::get( 'auth.app.login' ) );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * @brief   Return a Guard
     *  
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return $this->guard;
    }
}
