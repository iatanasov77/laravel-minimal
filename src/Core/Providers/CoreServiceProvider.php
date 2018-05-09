<?php namespace Icover\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerBladeDirectives();
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * Register config.
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        // Asset
        Blade::directive( 'asset', function ( $path )
        {
            return sprintf( "/%s/%s", config( 'app.assets_root' ), $path );
        });
        
        // Ifcontinue
        Blade::directive( 'ifcontinue', function ( $expression )
        {
            return "<?php if( {$expression} ) continue; ?>";
        });
        
        // Ifbreak;
        Blade::directive( 'ifbreak', function ( $expression )
        {
            return "<?php if( {$expression} ) break; ?>";
        });
    }
}
