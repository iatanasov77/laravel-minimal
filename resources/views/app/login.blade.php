<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="@asset( app/img/favicon.png )">
    
   	<title>{{ config( 'app.title' ) }}</title>
    
    <link href="@asset( app/css/common.css )" rel="stylesheet">
    
    <!-- IE8 support of HTML5 -->
    <!--[if lt IE 9]>
        <script src="@asset( app/js/lt_ie9.js )"></script>
    <![endif]-->
</head>

<body class="login-img3-body">

    <div class="container"> 
        {{ Form::open( ['route' => 'app.auth.login', 'class' => 'login-form'] ) }}	
        	
            <div class="login-wrap">
                <p class="login-img"><i class="icon_lock_alt"></i></p>
                
            @if( Session::has( 'loginError' ) )
                <div class="row" style="text-align:center; margin-bottom:10px; color: #CC5665; font-weight:bold; font-size:14px;">
                	{{ Session::get( 'loginError' ) }}
               	</div>
           	@endif
           	  	
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_profile"></i></span>
                    <input name="email" type="text" class="form-control" placeholder="Email" autofocus>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                    <input name="password" type="password" class="form-control" placeholder="Password">
                </div>
                <label class="checkbox">
                    <input type="checkbox" value="rememberme"> Remember me
                </label>
                <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                <a href="{{ route( 'app.registration.show-form' ) }}" class="btn btn-info btn-lg btn-block" >Signup</a>
            </div>
          {{ Form::close() }}
    </div>
    
</body>
</html>

