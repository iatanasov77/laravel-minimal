@extends( 'app.layout' )

@section( 'content' )
	<div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
            	<li><i class="fa fa-home"></i><a href="/"  class="tip-bottom">Home</a></li>
            	<li><i class="icon_genius"></i>Users</li>
            </ol>
        </div>
    </div>
    
@if( Session::has( 'formMessage' ) )
    <div class="alert alert-block alert-info fade in">
        <button type="button" class="close close-sm" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        {{ Session::get( 'formMessage' ) }}
    </div>
@endif
    
    <div class="tab-pane active">
    	<section class="panel">                                          
            <div class="panel-body bio-graph-info">
            	<div class="row">
            		<div class="col-lg-10"><a href="{{ route( 'resources.users.create' ) }}" class="btn btn-primary" >Create User</a></div>
        			<div class="col-lg-2"><h1> Users Listing</h1></div>
        		</div>
              	<table class="table table-striped table-advance table-hover">
                	<tr>
                        <th width="50">N</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th width="150">Action</th>
                    </tr>
                @foreach( $items as $itm )
                    <tr>
                        <td>
                            {{ $itm->id }}
                        </td>
                        <td>
                            {{ $itm->email }}
                        </td>
                        <td>
                            <a href="">
                                {{ $itm->name }} {{ $itm->last_name }}
                            </a>
                        </td>
                        <td>
                        @if( $itm->id != Auth::user()->id )
                        	<div class="btn-group gridActions">
                                <a class="btn btn-primary btnEdit" href="{{ route( 'resources.users.edit', $itm->id ) }}"><i class="icon_pencil"></i></a>
                                <a class="btn btn-danger btnDelete" href="{{ route( 'resources.users.destroy', $itm->id ) }}"><i class="icon_close_alt2"></i></a>
                            </div>
                        @endif
                        </td>
                    </tr>
                @endforeach
            	</table>
            </div>
    	</section>
    </div>
@stop

@section( 'js' )
	@parent
	<script src="@asset( app/js/grid.js )"></script>
	
	<script type="text/javascript">
		$( function() 
		{
    		$( '.gridActions' ).LaragridActions({
        		csrfToken:	'{{ csrf_token() }}',
    			btnDelete:	'.btnDelete'
    		});
		});
	</script>
@stop

@section( 'css' )
	@parent
	<link href="@asset( app/css/common.css )" rel="stylesheet">
@stop
