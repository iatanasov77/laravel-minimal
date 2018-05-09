<?php namespace App\Resources\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

use Icover\Core\CRUD\ResourceController;
use App\Resources\Entities\Role;

class UsersController extends ResourceController
{
    const UPLOAD_DIR    = DIRECTORY_SEPARATOR . 'um'  . DIRECTORY_SEPARATOR . 'users';
    
    const GRID_TITLE    = 'Users Listing';
    const PAGE_SIZE     = 20;
    
    public function create( Request $request )
    {
        return parent::create( $request )->with( 'roles', Role::pluck( 'name', 'id' )->toArray() );
    }

    public function edit( $id, $locale = null )
    {
        return parent::edit( $id )->with( 'roles', Role::pluck( 'name', 'id' )->toArray() );
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    protected function preSave( Request $request, Model &$entity, array &$input )
    {
        if ( $request->hasFile( 'item.image' ) )
        {
            $image              = $request->file( 'item.image' );
            $rename             = md5( time() ) . '.' . $image->getClientOriginalExtension();
            $destinationPath    = config( 'app.upload_path' ) . self::UPLOAD_DIR . DIRECTORY_SEPARATOR;
            
            if ( $image->move( $destinationPath, $rename ) )
            {
                $input['image']     = self::UPLOAD_DIR . DIRECTORY_SEPARATOR . $rename;
            }
        }
        
        // If password not changed on update , set the old one
        $input['password']  = empty( $input['password'] )
                                ? $entity->password
                                : Hash::make( $input['password'] );
    }

    protected function postSave( Model &$entity, array $input )
    {
        if ( isset( $input['roles'] ) && is_array( $input['roles'] ) )
        {
            $entity->roles()->sync( $input['roles'] );
        }
    }
}
