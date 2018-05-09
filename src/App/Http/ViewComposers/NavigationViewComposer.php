<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

/**
 * @brief   View composer for the sidebar menu
 * 
 * @author I. Atanasov <i.atanasov77@gmail.com>
 */
class NavigationViewComposer
{
    /**
     * @brief   Implement the compose method
     * 
     * @param   \Illuminate\Contracts\View\View $view
     * 
     * @return  void
     */
    public function compose( View $view )
    {
        if( Auth::check() )
        {
            $nav    = [
                'app.home'                  => ['url' => '/', 'label' => 'Home', 'icon' => 'fa fa-home' ],
                'modules.um.users.index'    => ['url' => '/users', 'label' => 'Users', 'icon' => 'icon_genius' ],
            ];
        }
        
        $currentRoute   = Request::route()->getName();
        if ( isset( $nav[$currentRoute] ) )
        {
            $nav[$currentRoute]['class']    = 'active';
        }
        
        $view->with( ['nav' => $nav] );
    }
}
