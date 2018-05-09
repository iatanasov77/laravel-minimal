<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Resources\Controllers\UsersController;
use App\Http\Requests\RegistrationRequest;
use App\Resources\Entities\User;
use App\Resources\Entities\Role;

/**
 * @brief   Registration Controller
 *
 * @author  Ivan Atanasov
 */
class RegistrationController extends UsersController
{
    const DEFAULT_ROLE  = Role::USER;
    
    /**
     * @brief   Show registration form action
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showForm()
    {
        return View::make( 'app.registration' );
    }
    
    /**
     * @brief   Save registration form action
     *
     * @var \App\Http\Requests\RegistrationRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm( RegistrationRequest $request )
    {
        $user           = new User();
        $input          = $request->input( 'item' );
        
        $this->saveItem( $request, $user, $input );
        $user->roles()->attach( self::DEFAULT_ROLE );
		
        // redirect
        Session::flash( 'formMessage', 'Successfully create profile!' );
        return Redirect::to( '/users' );
    }
}
