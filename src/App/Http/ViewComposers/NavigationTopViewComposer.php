<?php namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * @brief   View composer for the top profile menu
 * 
 * @author I. Atanasov <i.atanasov77@gmail.com>
 */
class NavigationTopViewComposer
{
    /**
     * Implement the compose method
     * 
     * @param   \Illuminate\Contracts\View\View $view
     * 
     * @return  void
     */
    public function compose( View $view )
    {
        if( Auth::check() )
        {
            $view->with( ['user' => Auth::user()] );
        }
    }
}
