<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;

/**
 * @brief RedirectIfAuthenticated middleware
 *
 * @author Ivan Atanasov
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * 
     * @return mixed
     */
    public function handle( $request, Closure $next, $guard = null )
    {
        $isAuth = Auth::guard( $guard )->check();
        if ( $isAuth )
        {
            return Redirect::intended( Config::get( 'auth.app.home' ) );
        }

        return $next( $request );
    }
}
