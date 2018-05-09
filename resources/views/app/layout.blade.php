<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="@asset( app/img/favicon.png )">
    
   	<title>{{ config( 'app.title' ) }}</title>
    
    @yield( 'css' )
    
    <!-- IE8 support of HTML5 -->
    <!--[if lt IE 9]>
        <script src="@asset( app/js/lt_ie9.js )"></script>
    <![endif]-->
</head>

<body>
	<!-- container section start -->
	<section id="container">
		<header class="header dark-bg">
			<div class="toggle-nav">
				<div class="icon-reorder tooltips"
					data-original-title="Toggle Navigation" data-placement="bottom">
					<i class="icon_menu"></i>
				</div>
			</div>

			<!--logo start-->
			<a href="/" class="logo">{{ config( 'app.title' ) }}</a>
			<!--logo end-->

		

			<div class="top-nav notification-row">
				<!-- notificatoin dropdown start-->
				@include( 'app.partial.navigation.top' )
				<!-- notificatoin dropdown end-->
			</div>
		</header>
		<!--header end-->

		<!--sidebar start-->
		<aside>
			<div id="sidebar" class="nav-collapse ">
				<!-- sidebar menu start-->
				@include( 'app.partial.navigation.sidebar' )
				<!-- sidebar menu end-->
			</div>
		</aside>
		<!--sidebar end-->

		<!--main content start-->
		<section id="main-content">
			<section class="wrapper">
				@yield( 'content' )
			</section>
		</section>
		<!--main content end-->
	</section>
	<!-- container section end -->

	<!-- javascripts -->
@section( 'js' )
	<script src="@asset( app/js/layout.js )"></script>
@show
	
</body>
</html>
