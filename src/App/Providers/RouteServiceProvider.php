<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * @brief   View composer for the sidebar menu
 *
 * @author I. Atanasov <i.atanasov77@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * @brief   This namespace is applied to your controller routes.
     *
     * @detail   In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * @brief   Define your route model bindings, pattern filters, etc.
     *
     * @return  void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * @brief   Define the routes for the application.
     *
     * @return  void
     */
    public function map()
    {
        $this->mapWebRoutes();
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * @brief   Define the "web" routes for the application.
     *
     * @detail  These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
}
