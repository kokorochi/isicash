<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Isicash - Semua Kebutuhan Voucher Anda</title>

    <meta name="keywords" content="">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800'
          rel='stylesheet' type='text/css'>

    <!-- Bootstrap and Font Awesome css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Css animations  -->
    <link href="{{url('css/animate.css')}}" rel="stylesheet">

    <!-- Theme stylesheet, if possible do not edit this stylesheet -->
    <link href="{{url('css/style.default.css')}}" rel="stylesheet" id="theme-stylesheet">

    <!-- Custom stylesheet - for your changes -->
    <link href="{{url('css/custom.css')}}" rel="stylesheet">

    <!-- Responsivity for older IE -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and apple touch icons-->
    <link rel="shortcut icon" href="img/isicash-icon.png"/>
{{--<link rel="apple-touch-icon" href="img/isicash-icon.png"/>--}}
<!-- owl carousel css -->

    <link href="{{url('css/owl.carousel.css')}}" rel="stylesheet">
    <link href="{{url('css/owl.theme.css')}}" rel="stylesheet">
</head>

<body>

<div id="all">

    @include("layouts.header")

    @include("layouts.login-modal")

    @yield("content")

    {{--@include("layouts.footer")--}}

    @include("layouts.copyright")

</div>
<!-- /#all -->

<!-- #### JAVASCRIPT FILES ### -->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')
</script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script src="{{url('js/bootstrap-notify.min.js')}}"></script>
<script src="{{url('js/jquery.cookie.js')}}"></script>
<script src="{{url('js/waypoints.min.js')}}"></script>
<script src="{{url('js/jquery.counterup.min.js')}}"></script>
<script src="{{url('js/jquery.parallax-1.1.3.js')}}"></script>
<script src="{{url('js/front.js')}}"></script>

@php
    if(!isset($sessions))
    {
        foreach (['danger', 'warning', 'success', 'info'] as $msg)
        {
            if(Session::has('alert-' . $msg))
            {
                $sessions['alert-' .$msg] = Session::get('alert-' . $msg);
            }
        }
    }
@endphp
<script>
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(isset($sessions['alert-' . $msg]))
            $.notify({
                message: "{{$sessions['alert-' . $msg]}}"
            },{
                type: "{{$msg}}"
            })
        @endif
    @endforeach
</script>

<!-- owl carousel -->
<script src="{{url('js/owl.carousel.min.js')}}"></script>

</body>

</html>