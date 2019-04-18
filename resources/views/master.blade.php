<!DOCTYPE html>
<html>

<head>

    <title>Courier Tracking Notification &middot; Get Notified Now!</title>
    <meta name="description" content="Never missed any updates of your item by receiving through email! Currently only Poslaju and Skynet are supported.">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/icon-7-stroke/css/pe-icon-7-stroke.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet" media="screen">
    <link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" media="screen">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:100,300,400,700' rel='stylesheet' type='text/css'>
</head>

<body data-spy="scroll" data-target="#navbar-scroll">
    <div id="top"></div>
    <div class="fullscreen landing parallax" style="background-image:url('{{ asset("images/bg.jpg") }}');" data-img-width="2000" data-img-height="1325" data-diff="100">

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h1 class="wow fadeInLeft">
                            Courier Tracking Notification
                        </h1>
                        <div class="landing-text wow fadeInUp">
                            <p>Never missed any updates of your item by receiving through email! Currently only Poslaju and Skynet are supported.</p>
                        </div>
                        <div class="head-btn wow fadeInLeft">
                            <a href="#" class="btn-primary">How It Works</a>
                            <a href="#" class="btn-default">Track Now</a>
                        </div>
                        <br />
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="menu">
        <nav class="navbar-wrapper navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-themers">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand site-name" href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
                </div>
                <div id="navbar-scroll" class="collapse navbar-collapse navbar-themers navbar-right">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#tracking">Tracking</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    @yield('content')

    <footer id="footer">
        <div class="container">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="social text-center">
                    <ul>
                        <li><a class="wow fadeInUp" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                        <li><a class="wow fadeInUp" href="https://www.facebook.com/" data-wow-delay="0.2s"><i class="fa fa-facebook"></i></a></li>
                        <li><a class="wow fadeInUp" href="https://plus.google.com/" data-wow-delay="0.4s"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
                <div class="text-center wow fadeInUp" style="font-size: 14px;display:none">Copyright Businessr 2019 - <a href="https://webthemez.com/free-bootstrap-templates/" target="_blank" title="Free Bootstrap Templates">Free Bootstrap Templates</a> by WebThemez.</div>
                <a href="#" class="scrollToTop"><i class="pe-7s-up-arrow pe-va"></i></a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/ekko-lightbox-min.js') }}"></script>
    <script type="text/javascript">
        $(document).delegate('*[data-toggle="lightbox"]', 'click', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });
    </script>
    <script>
        new WOW().init();
    </script>
</body>

</html>
