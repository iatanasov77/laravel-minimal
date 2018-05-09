<?php namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Response;

/**
 * @brief File Manager Controller
 * @details This controller is used to provide the file uploaded from this system 
 *          and not into the document root dir
 *
 * @author Ivan Atanasov
 */
class FileManagerController extends Controller
{
    /**
     * @brief   Show file action
     * 
     * @param   string $fileId
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function show( $fileId )
    {
        $parts  = explode( '-', $fileId );
        $entity = DB::table( $parts[0] )->find( ( int ) $parts[2] );
        if ( ! $entity || empty( $entity->{$parts[1]} ) )
        {
            abort( 404 );
        }

        $path       = Config::get( 'app.upload_path' ) . DIRECTORY_SEPARATOR . $entity->{$parts[1]};
        $headers    = [
            'Content-Type'  => mime_content_type( $path )
        ];
        
        return response()->file( $path, $headers );
    }
}
