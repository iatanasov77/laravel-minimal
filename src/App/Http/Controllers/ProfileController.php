<?php namespace App\Http\Controllers;

use App\Resources\Controllers\UsersController as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\UploadedFile;
use App\Resources\Entities\User;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ProfileUpdateRequest;

/**
 * @brief Profile Controller
 *
 * @author Ivan Atanasov
 */
class ProfileController extends BaseController
{
    /**
     * @brief   Show profile form action
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showForm()
    {
        return View::make( 'app.profile', [
            'user'    => Auth::user()
        ]);
    }
    
    /**
     * @brief   Save profile action
     *
     * @var \App\Http\Requests\ProfileUpdateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitForm( ProfileUpdateRequest $request )
    {
        $user   = Auth::user();
        $input  = $request->input( 'item' );
        if ( ! $user )
        {
            throw new \Exception( 'Error on update profile' );
        }
        
        $this->saveItem( $request, $user, $input );
        
        // redirect
        Session::flash( 'formMessage', 'Successfully update profile!');
        return Redirect::to( '/users' );
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /**
     * @brief   Upload a photo to the storage upload directory
     * 
     * @param   \Illuminate\Http\UploadedFile $image
     * 
     * @return  string|NULL
     */
    protected function uploadPhoto( UploadedFile $image )
    {
        $rename             = md5( time() ) . '.' . $image->getClientOriginalExtension();
        $destinationPath    = Config::get( 'app.upload_path' ) . DIRECTORY_SEPARATOR;
        
        if ( $image->move( $destinationPath, $rename ) )
        {
            return $rename;
        }
        
        return null;
    }
}
