<!DOCTYPE html>
<html lang="es">

<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RESERVA TU ESPACIO</title>

    <!-- CSS -->
    <link href="css/bootstrap.min.css?v={{date('yyyymmddMMhhss')}}" rel="stylesheet" type="text/css">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/nivo-lightbox.css" rel="stylesheet" />
    <link href="css/nivo-lightbox-theme/default/default.css" rel="stylesheet" type="text/css" />
    <link href="css/owl.carousel.css" rel="stylesheet" media="screen" />
    <link href="css/owl.theme.css" rel="stylesheet" media="screen" />
    <link href="css/animate.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <link href="color/default.css" rel="stylesheet">

    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">


</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
<!-- Preloader -->
<div id="preloader">
    <div id="load"></div>
</div>

<!-- Section: intro -->
<section id="intro" class="intro">

    <div class="slogan">
        <a href="#"><img src="img/touch_logo.png" alt="LOGO" width="294" height="274" /></a>
    </div>
    <div class="page-scroll">
        <a href="#about">
            <i class="fa fa-angle-down fa-5x animated"></i>
        </a>
    </div>
</section>
<!-- /Section: intro -->

<!-- Navigation -->
<div id="navigation">
    <nav class="navbar navbar-custom" role="navigation">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="menu">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#intro">INICIO</a></li>
                            <li><a href="#about">NOSOTROS</a></li>
                            <li><a href="#tutorial">TUTORIAL</a></li>
                            <li><a href="#sistema">SISTEMA</a></li>
                        </ul>
                    </div>
                    <!-- /.Navbar-collapse -->

                </div>
            </div>
        </div>
        <!-- /.container -->
    </nav>
</div>
<!-- /Navigation -->

<!-- Section: about -->
<section id="about" class="home-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">

                <div class="section-heading text-center">
                    <div class="wow bounceInDown" data-wow-delay="0.2s">
                        <h2>NOSOTROS</h2>
                    </div>
                    <p class="wow bounceInUp" data-wow-delay="0.3s">Nuestro proyecto de tesis busca reservar las salas desocupadas para uso academico, ya sea trabajos, tutorias, etc.</p>
                </div>

            </div>
        </div>
    </div> <!-- fin container-->

    <div class="container">
        <!-- Francisco -->
        <div class="col-sm-4">
            <div class="people wow bounceInLeft" data-wow-delay=".25s">
                <img class="img-circle" src="img/pp3.jpg" alt="Francisco Acevedo" />
                <h3>Francisco Acevedo</h3>
                <p>
                    Pancho
                </p>
            </div>
        </div>


        <!-- Raul -->
        <div class="col-sm-4">
            <div class="people wow bounceInUp" data-wow-delay=".25s">
                <img class="img-circle" src="img/pp2.jpg" alt="Ra�l Espinoza" />
                <h3>Ra&uacutel Espinoza</h3>
                <p>
                    Tremito
                </p>
            </div>
        </div>


    <!-- Alvaro -->
    <div class="col-sm-4">
        <div class="people wow bounceInRight" data-wow-delay=".25s">
        <img class="img-circle" src="img/pp1.jpg" alt="Alvaro Ortega" />
        <h3>Alvaro Ortega</h3>
        <p>
            Alvaro
        </p>
    </div>
    </div>

    </div>
</section>
<!-- /Section: about -->

<!-- Section: Tutorial -->
<section id="tutorial" class="home-section text-center bg-gray">

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="wow bounceInDown" data-wow-delay="0.4s">
                    <div class="section-heading">
                        <h2>TUTORIAL</h2>
                        <p>Aprende a utilizar nuestro sistema</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12" >
                <div class="wow bounceInUp" data-wow-delay="0.4s">
                    <div class="video-responsive">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/5SfDgxxx8b4?ecver=1" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /Section: tutorial -->

<!-- Section: Login -->
<section id="sistema" class="home-section text-center">
    

       <div class="container">

            @yield('logear')

       </div>

</section>
<!-- /Section: login -->

<!-- Footer -->
<footer>
    <div class="container">
        @yield('footerql')
    </div>
</footer>


<!-- fin footer -->

<!-- Core JavaScript Files -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/jquery.scrollTo.js"></script>
<script src="js/stellar.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/nivo-lightbox.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/custom.js"></script>

</body>

</html>
