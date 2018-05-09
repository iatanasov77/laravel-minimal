<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;

/**
 * @brief   Main Application service provider
 *
 * @author I. Atanasov <i.atanasov77@gmail.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * @brief   Bootstrap any application services.
     *
     * @return  void
     */
    public function boot()
    {
        Schema::defaultStringLength( 191 );
        
        View::composer( "app.partial.navigation.top", "App\Http\ViewComposers\NavigationTopViewComposer" );
        View::composer( "app.partial.navigation.sidebar", "App\Http\ViewComposers\NavigationViewComposer" );
    }

    /**
     * @brief   Register any application services.
     *
     * @return  void
     */
    public function register()
    {
       
    }
}
