@extends( 'app.layout' )

@section( 'content' )
	<div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
            	<li><i class="fa fa-home"></i><a href="/"  class="tip-bottom">Home</a></li>
            	<li><i class="icon_genius"></i><a href="/users"  class="tip-bottom">Users</a></li>
            	<li><i class="icon_genius"></i>Create New User</li>
            </ol>
        </div>
    </div>

@if( $errors->count() > 0 )
    <div class="row">
        <div class="col-lg-12 alert alert-block alert-danger fade in">
            <button data-dismiss="alert" class="close close-sm" type="button">
            	<i class="icon-remove"></i>
            </button>
        	<ul>
        	@foreach($errors->all() as $error)
        		<li><strong>{{ $error }}</strong></li>           
        	@endforeach
        	</ul>
        </div>
    </div>
@endif

	<div class="tab-pane active">
        <section class="panel">                                          
        	<div class="panel-body bio-graph-info">
        	@if( isset( $item ) )
        		<h1>Edit User</h1>
        		{{ Form::model( ['item' => $item], [
        			'class' => 'form-horizontal', 
        			'route' => ['resources.users.update', $item->id], 
        			'method' => 'patch', 
        			'files' => true])
        		}}
			@else
				<h1>Create New User</h1>
    			{{ Form::open( [ 
    				'class' => 'form-horizontal', 
    				'route' => 'resources.users.store', 
    				'files' => true] ) 
    			}}
			@endif
					<div class="form-group">
                        <label class="col-lg-2 control-label">Avatar</label>
                        <div class="col-lg-2">
                        @if( isset( $item ) )
                        	<img src="{{ get_uploaded_file( 'um_users', 'image', $item->id ) }}" />
                        @endif
                        </div>
                        <div class="col-lg-4">
                        	<input name="item[image]" type="file" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">ACL Role</label>
                    	<div class="col-lg-6">
                        	{{ Form::select( 'item[roles][]', $roles, null, ['class' => 'form-control', 'multiple'] ) }}
                    	</div>
                    </div>                                          
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">First Name</label>
                    	<div class="col-lg-6">
                    		{{ Form::text( 'item[name]', Input::old( 'item[name]' ), ['class' => 'form-control'] ) }}
                      	</div>
                    </div>
                    <div class="form-group">
                    	<label class="col-lg-2 control-label">Last Name</label>
                    	<div class="col-lg-6">
                    		{{ Form::text( 'item[last_name]', Input::old( 'item[last_name]' ), ['class' => 'form-control'] ) }}
                    	</div>
                    </div>
                      
                  	<div class="form-group">
                        <label class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-6">
                        	{{ Form::text( 'item[email]', Input::old( 'item[email]' ), ['class' => 'form-control'] ) }}
                        </div>
					</div>
                      
					<div class="form-group">
                        <label class="col-lg-2 control-label">Password</label>
                        <div class="col-lg-6">
                          <input name="item[password]" type="password" class="form-control" id="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Password confirm</label>
                        <div class="col-lg-6">
                          <input name="password_confirm" type="password" class="form-control" id="password_confirm">
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                          <button type="submit" class="btn btn-primary">Save</button>
                          <a href="javascript:history.go( -1 );" class="btn btn-danger">Cancel</a>
                      </div>
                    </div>
              	{{ Form::close() }}
            </div>
		</section>
    </div>
@stop

@section( 'css' )
	@parent
	<link href="@asset( app/css/common.css )" rel="stylesheet">
@stop
