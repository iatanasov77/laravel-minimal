@extends( 'app.layout-guest' )

@section( 'content' )
	<div class="login-wrap">
        <h1>Registration</h1>
 
    @if( $errors->count() > 0 )
        <div class="row">
        	<div class="col-sm-2"></div>
            <div class="col-sm-8 alert alert-block alert-danger fade in">
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
	
		<div class="row">
        	<div class="col-sm-2"></div>
            <div class="col-sm-8 alert alert-block alert-info fade in">
                <button data-dismiss="alert" class="close close-sm" type="button">
                	<i class="icon-remove"></i>
                </button>
				<strong>All fields are mandatory. Max file size for the image is 1 MB.</strong>
            </div>
        </div>
		
        {{ Form::open( ['route' => 'app.registration.submit-form', 'class' => 'form-horizontal', 'files' => true] ) }}
        	<div class="form-group">
                <label class="col-lg-2 control-label">Avatar</label>
                <div class="col-lg-8">
                	<input name="item[image]" type="file" class="form-control" />
                </div>
            </div> 
        	<div class="form-group">
        		<label class="col-sm-2 control-label">First name</label>
        		<div class="col-sm-8">
        			<input name="item[name]" type="text" class="form-control">
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label class="col-sm-2 control-label">Last name</label>
        		<div class="col-sm-8">
        			<input name="item[last_name]" type="text" class="form-control">
        		</div>
        	</div>
        	
        	<div class="form-group"></div>
        	
        	<div class="form-group">
        		<label class="col-sm-2 control-label">Email</label>
        		<div class="col-sm-8">
        			<input name="item[email]" type="text" class="form-control">
        		</div>
        	</div>
        	
        	<div class="form-group">
        		<label class="col-sm-2 control-label">Password</label>
        		<div class="col-sm-8">
        			<input name="item[password]" type="password" class="form-control">
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="col-sm-2 control-label">Confirm Password</label>
        		<div class="col-sm-8">
        			<input name="password_confirm" type="password" class="form-control">
        		</div>
        	</div>
        	<div class="form-group">
            	<div class="col-lg-offset-2 col-lg-10">
                	<button type="submit" class="btn btn-primary">Save</button>
              	</div>
			</div>
        {{ Form::close() }}
    </div>
@stop