@extends( 'app.layout' )

@section( 'content' )
	<div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
            	<li><i class="fa fa-home"></i><a href="/"  class="tip-bottom">Home</a></li>
            	<li><i class="icon_genius"></i>My Profile</li>
            </ol>
        </div>
    </div>
    
@if ( $errors->count() > 0 )
    <div class="alert alert-block alert-danger fade in">
        <button type="button" class="close close-sm" data-dismiss="alert">
            <i class="icon-remove"></i>
        </button>
        <strong>Error saving form!</strong>
    @foreach( $errors as $err )
    	<p>{{ $err }}</p>
    @endforeach 
    </div>
@endif

	<div class="tab-pane active">
        <section class="panel">                                          
            <div class="panel-body bio-graph-info">
                <h1>My Profile</h1>
                {{ Form::model( ['item' => $user], [
        			'class' => 'form-horizontal', 
        			'route' => ['app.profile.submit-form'], 
        			'method' => 'post', 
        			'files' => true])
        		}}
                	<div class="form-group">
                        <label class="col-lg-2 control-label">Avatar</label>
                        <div class="col-lg-2">
                        @if( isset( $user->image ) )
                        	<img src="{{ get_uploaded_file( 'um_users', 'image', $user->id ) }}" width="150"/>
                        @endif
                        </div>
                        <div class="col-lg-4">
                        	<input name="item[image]" type="file" class="form-control" style="margin-top: 105px" />
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
                          <input name="password" type="password" class="form-control" id="password">
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
				</form>
			</div>
		</section>
    </div>
@stop

@section( 'css' )
	@parent
	<link href="@asset( app/css/common.css )" rel="stylesheet">
@stop
