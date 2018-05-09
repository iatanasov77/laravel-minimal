
let mix	= require( 'laravel-mix' );

mix
	//Login page styles
	.styles([
		'resources/themes/NiceAdmin/bower_components/bootstrap/dist/css/bootstrap.css',
		'resources/themes/NiceAdmin/bower_components/bootstrap/dist/css/bootstrap-theme.css',
		'resources/themes/NiceAdmin/bower_components/elegant-icons/css/style.css',
		'resources/themes/NiceAdmin/bower_components/fontawesome/css/font-awesome.css',
		'resources/themes/NiceAdmin/bower_components/BootstrapAdmin/css/style.css',
		'resources/themes/NiceAdmin/bower_components/BootstrapAdmin/css/style-responsive.css'
		
	], 'public/assets/app/css/common.css' )
	
	// Responsive for IE < 9
	.scripts([
		'resources/themes/NiceAdmin/bower_components/html5shiv/dist/html5shiv.js',
		'resources/themes/NiceAdmin/bower_components/respond/src/respond.js',
	], 'public/assets/app/js/lt_ie9.js' )
	
	// Layout scripts
	.scripts([
		'resources/themes/NiceAdmin/bower_components/jquery/dist/jquery.js',
		'resources/themes/NiceAdmin/bower_components/bootstrap/dist/js/bootstrap.js',
		'resources/themes/NiceAdmin/bower_components/jquery.scrollTo/jquery.scrollTo.js',
		'resources/themes/NiceAdmin/bower_components/jquery.nicescroll/dist/jquery.nicescroll.js',
		'resources/themes/NiceAdmin/bower_components/BootstrapAdmin/js/scripts.js'
	], 'public/assets/app/js/layout.js' )
	
	// Grid scripts
	.scripts([
		'resources/assets_dev/js/jquery.laragrid.actions.js',
	], 'public/assets/app/js/grid.js' )
	
	// Theme images
	.mix.copyDirectory(
		'resources/themes/NiceAdmin/bower_components/BootstrapAdmin/img/*', 'public/assets/app/img/'
	)
	
	// Bootstrap fonts
	.mix.copyDirectory(
		'resources/themes/NiceAdmin/bower_components/bootstrap/fonts/*', 'public/assets/app/fonts/'
	)
	
	// Fontawesome fonts
	.mix.copyDirectory(
		'resources/themes/NiceAdmin/bower_components/fontawesome/fonts/*', 'public/assets/app/fonts/'
	)
	
	// Elegant icons fonts
	.mix.copyDirectory(
		'resources/themes/NiceAdmin/bower_components/elegant-icons/fonts/*', 'public/assets/app/fonts/'
	)
