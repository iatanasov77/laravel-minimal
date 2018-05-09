<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
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
<body>
    <section id="container" class="">
    
        <header class="header dark-bg">
            <a class="logo" href="/">
                <h1><span style="font-weight: bold;">{{ config( 'app.title' ) }}</span></h1>
            </a>
            
            <div class="top-nav notification-row">                
                <ul class="nav pull-right top-menu">
                    <li><a href="{{ route( 'app.auth.form' ) }}" style="color: #FFFFFF;">login</a></li>
                    <li><a href="{{ route( 'app.registration.show-form' ) }}" style="color: #FFFFFF;">register</a></li>
                </ul>
            </div> 
        </header>
        
        <section id="wide-content">
            <section class="wrapper">
                @yield( 'content' )
            </section>
        </section>
        
        <footer class="container-fluid">
            
        </footer>
        
    </section>
</body>
</html>
