<?php namespace Icover\Core\CRUD;

use Devfactory\Taxonomy\Facades\TaxonomyFacade as Taxonomy;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use Icover\Core\Model\Interfaces\MetadataAwareInterface;
use Icover\Core\Model\Interfaces\TaxonomyAwareInterface;
use Icover\Core\Model\Interfaces\TranslateAwareInterface;
use Icover\Core\Model\Interfaces\SortAwareInterface;
use Icover\Core\Model\Interfaces\ActivatableAwareInterface;
use Icover\Core\Http\Status;

use Icover\Core\CRUD\Exception\ResourceControllerException;

/**
 * @brief   Parent controller to all of CRUD resources
 * 
 * @author  I. Atanasov <i.atanasov77@gmail.com>
 *
 */
class ResourceController extends Controller
{
	const SORT_METHOD_AFTER    = 'moveAfter';
	const SORT_METHOD_BEFORE   = 'moveBefore';

    const PAGE_SIZE = 10;

    /**
     * @brief   The cannonical name of the resource
     * 
     * @var string
     */
    private $resourceName;

    /**
     * @brief   The resource config array
     * 
     * @var     array
     */
    protected $config;

    /**
     * @brief Initialize the resource controller
     */
    public function __construct()
    {
        $this->initResource();
        
        app()->bind( Request::class, function ( $app )
        {
            return $app->make( $this->config['requestClass'] );
        });
    }

    /**
     * @brief   This action return the json data of the requested item
     * 
     * @param   \Illuminate\Http\Request $request
     * 
     * @return  \Illuminate\Http\JsonResponse
     */
    public function item( Request $request )
    {
        $id     = $request->get( 'id' );
        $locale = $request->get( 'locale' );

        $item   = $this->find( $id );
        if ( $item && $locale )
        {
            $item   = $item->translate( $locale );
        }

        if ( $item )
        {
            $itemArray  = $item->toArray();
        }
        else
        {
            $item   = new $this->config['entityType']();
            $itemArray  = [];
            foreach ( $item->translatedAttributes as $attr )
            {
                $itemArray[$attr]   = '';
            }
        }

        return response()->json( ['item' => $itemArray] );
    }

    /**
     * @brief   Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        return view( $this->getView( 'list' ), [ 'items' => $this->getItems( $request )->paginate( self::PAGE_SIZE ) ] );
    }

    /**
     * @brief   Show the form for creating a new resource.
     *
     * @return  \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
        return view( $this->getView( 'edit' ),
            [
                'locale'    => $request->get( 'locale', App::getLocale() ),
                'terms'     => $this->getTerms()
            ]
        );
    }

    /**
     * @brief   Store a newly created resource in storage.
     *
     * @return  \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        $item   = new $this->config['entityType']();
        if ( $item instanceof TranslateAwareInterface )
        {
            $item->translate( $request->input( 'locale', App::getLocale() ) );
        }
        $input  = $request->input( 'item' );

        $this->saveItem( $request, $item, $input );

        // redirect
        Session::flash( 'formMessage', 'Successfully create item!' );

        return Redirect::to( $this->config['routePath'] );
    }

    /**
     * @brief   Show the specified resource.
     *
     * @param   int $id
     *
     * @return  \Illuminate\Http\Response
     */
    public function show( $id, Request $request )
    {
        $item   = $this->find( $id );

        return view( $this->getView( 'show' ), ['item'  => $item] );
    }

    /**
     * @brief   Show the form for editing the specified resource.
     *
     * @param   int $id
     *
     * @return  \Illuminate\Http\Response
     */
    public function edit( $id, $locale = null )
    {
        $item   = $this->find( $id );

        return view( $this->getView( 'edit' ),
        [
            'locale'    => $locale ?: App::getLocale(),
            'item'      => $item,
            'terms'     => $this->getTerms()
        ]);
    }

    /**
     * @brief   Update the specified resource in storage.
     *
     * @param   int $id
     *
     * @return  \Illuminate\Http\Response
     */
    public function update( $id, Request $request )
    {
        $item   = $this->find( $id );
        $input  = $request->input( 'item' );

        try
        {
            $this->saveItem( $request, $item, $input );
        }
        catch( Exception\SaveTaxonomyException $e )
        {
            report( $e );
        }

        // redirect
        Session::flash('message', 'Successfully update item!');
        return Redirect::to( $this->config['routePath'] );
    }

    /**
     * @brief   Remove the specified resource from storage.
     *
     * @param   int $id
     *
     * @return  \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        $item   = $this->find( $id );

        $item->delete();
        $this->postDelete( $item );

        // redirect
        Session::flash( 'formMessage', 'Successfully delete item!' );

        return Redirect::to( $this->config['routePath'] );
    }

    /**
     * @brief   Reorder the items
     *
     * @param   int $id
     *
     * @return  \Illuminate\Http\Response
     */
    public function order( Request $request )
    {
        $movedEntity    = $this->find( $request->input( 'movedItem' ) );
        if ( ! $movedEntity instanceof SortAwareInterface )
        {
            throw new \Exception( 'Entity should be instance of <<SortAwareInterface>>.' );
        }

        if ( $request->input( 'method' ) == self::SORT_METHOD_AFTER )
        {
            $movedEntity ->moveAfter( $this->find( $request->input( 'item' ) ) );
        }
        else
        {
            $movedEntity ->moveBefore( $this->find( $request->input( 'item' ) ) );
        }

        return response()->json( ['status' => Status::SUCCESS] );
    }

    /**
     * @brief   Set active flag on an item
     * 
     * @param   int $id
     * 
     * @return  \Illuminate\Http\Response
     */
    public function activate( $id )
    {
        $entity = $this->find( $id );
        if ( ! $entity instanceof ActivatableAwareInterface )
        {
            throw new \Exception( 'Entity should be instance of <<ActivatableAwareInterface>>.' );
        }

        $entity->activate();

        return Redirect::to( $this->config['routePath'] );
    }

    /**
     * @brief   Unset active flag on an item
     *
     * @param   int $id
     *
     * @return  \Illuminate\Http\Response
     */
    public function deactivate( $id )
    {
        $entity = $this->find( $id );
        if ( ! $entity instanceof ActivatableAwareInterface )
        {
            throw new \Exception( 'Entity should be instance of <<ActivatableAwareInterface>>.' );
        }

        $entity->deactivate();

        return Redirect::to( $this->config['routePath'] );
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @brief   Items query builder method
     * 
     * @param   \Illuminate\Http\Request $request
     * 
     * @return  \Illuminate\Database\Query\Builder
     */
    protected function getItems( Request $request )
    {
        if ( isset( $this->config['listMethod'] ) )
        {
            $method = $this->config['listMethod'];
            $items  = $this->config['entityType']::$method();
        }
        else
        {
            $items  = $this->config['entityType']::select();
        }

        $orderBy    = $request->get( 'orderBy' );
        if ( $orderBy )
        {
            foreach ( $orderBy as $column => $direction )
            {
                $items->orderBy( $column, $direction );
            }
        }
        else
        {
            $items->orderBy( 'id', 'desc' );
        }

        $filter = $request->get( 'filter', null );
        if ( $filter )
        {

            foreach ( $filter as $key => $val )
            {
                if ( ! $val || empty( $val ) )
                    continue;

                if ( is_array( $items->getModel()->translatedAttributes ) && in_array( $key, $items->getModel()->translatedAttributes ) )
                {
                    $items->whereTranslationLike( $key, '%' . $val . '%' );
                }
                else
                {
                    $items->where( $key, $val );
                }
            }
        }

        return $items;
    }

    /**
     * @brief   Pre-save hook method
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   \Illuminate\Database\Eloquent\Model &$entity
     * @param   array &$input
     * 
     * @return void
     */
    protected function preSave( Request $request, Model &$entity, array &$input )
    {
        if ( $entity instanceof TranslateAwareInterface )
        {
            $this->prepareTranslatable( $entity, $input, $request->input( 'locale', App::getLocale() ) );
        }
    }

    /**
     * @brief   Post-save hook method
     *
     * @param   \Illuminate\Database\Eloquent\Model &$entity
     * @param   array $input
     *
     * @return void
     */
    protected function postSave( Model &$entity, array $input )
    {
        if ( $entity instanceof MetadataAwareInterface && isset( $input['meta'] ) && is_array( $input['meta'] ) )
        {
            $this->saveMeta( $entity, $input );
        }

        if (
            $entity instanceof TaxonomyAwareInterface
            && property_exists( get_class( $entity ), 'taxonomyAttributes' )
            ) {
                $this->saveTaxonomy( $entity, $input );
            }
    }

    /**
     * @brief   Post-delete hook method
     *
     * @param   \Illuminate\Database\Eloquent\Model $entity
     *
     * @return void
     */
    protected function postDelete( Model $entity )
    {
    }

    /**
     * @brief   The Config getter
     *
     * @return  array
     */
    protected function config()
    {
        return $this->config;
    }

    /**
     * @brief   Initialize the resource
     * 
     * @detail This method extract the resource class name and load the resource config
     */
    protected function initResource()
    {
        $classSegments      = explode( '\\', get_class( $this ) );

        $this->resourceName = substr( array_pop( $classSegments ), 0, -10 );
        $this->config       = Config::get( 'resources.' . strtolower( $this->resourceName ) );
    }

    /**
     * @brief   Find an entity
     * 
     * @param   int $id
     * @return  \Illuminate\Database\Eloquent\Model
     */
    protected function find( $id )
    {
        if ( isset( $this->config['listMethod'] ) )
        {
            $method = $this->config['listMethod'];
            return $this->config['entityType']::$method()->find( $id );
        }

        return $this->config['entityType']::find( $id );
    }

    /**
     * @brief   Save an item to the database
     *
     * @param   int $id
     * @return  \Illuminate\Database\Eloquent\Model
     * 
     * @return  void
     */
    protected function saveItem( Request $request, Model &$item, array &$input )
    {
        $this->preSave( $request, $item, $input );

        $item->fill( $input );
        $item->save();

        $this->postSave( $item, $input );
    }

    /**
     * @brief   Save meta data of the entity
     
     * @param  \Illuminate\Database\Eloquent\Model &$entity
     * @param   array &$input
     * 
     * @return  void
     */
    protected function saveMeta( Model &$entity, array &$input )
    {
        foreach ( $input['meta'] as $key => $val )
        {
            $entity->updateMeta( $key, $val );
        }
    }

    /**
     * @brief   Save taxonomy data of the entity
     
     * @param  \Illuminate\Database\Eloquent\Model &$entity
     * @param   array &$input
     *
     * @return  void
     * 
     * @throws  Exception\SaveTaxonomyException
     */
    protected function saveTaxonomy( Model &$entity, array &$input )
    {
        try
        {
            $entity->removeAllTerms();
            foreach ( array_keys( get_class( $entity )::$taxonomyAttributes ) as $property )
            {
                $terms  = is_array( $input[$property . 'Id'] ) ? $input[$property . 'Id'] : [ $input[$property . 'Id'] ];
                foreach ( $terms as $termId )
                {
                    $entity->addTerm( $termId );
                }
            }
        }
        catch ( \Exception $e )
        {
            throw new Exception\SaveTaxonomyException( $e->getMessage() );
        }
    }

    /**
     * @brief   Get View by its type
     * 
     * @param   string $type
     * 
     * @throws  \Icover\Core\CRUD\Exception\ResourceControllerException
     *          if cannot resolve the requested view
     * 
     * @return  string
     */
	protected function getView( $type )
	{
		if (
	        isset( $this->config['views'] )
	        && is_array( $this->config['views'] )
	        && isset( $this->config['views'][$type] )
	    ) {
			return $this->config['views'][$type];
		}
		elseif( isset( $this->config['viewNamespace'] ) )
		{
			return $this->config['viewNamespace'] . '.' . $type;
		}

		throw new ResourceControllerException( 'Resource config: views not configured.' );
	}

	/**
	 * @brief  Get taxonomy terms related to this resource
	 * 
	 * @return array
	 */
    private function getTerms()
    {
        $terms  = [];

        if ( property_exists( $this->config['entityType'], 'taxonomyAttributes' ) )
        {
            foreach ( $this->config['entityType']::$taxonomyAttributes as $property => $vocabulary )
            {
                $terms[$property] = Taxonomy::getVocabularyByName( $vocabulary )
                                            ->terms()
                                            ->pluck( 'name', 'id' )
                                            ->toArray();
            }
        }

        return $terms;
    }
}
