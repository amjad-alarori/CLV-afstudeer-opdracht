<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
@endif

<!-- Favicon -->
    <link rel="shortcut icon" href="{{ url(asset('favicon.ico')) }}">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ url(mix('js/app.js')) }}" defer></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.tutorialjinni.com/jquery-csv/1.0.11/jquery.csv.min.js"></script>
    <script type="text/javascript" src="//unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
</head>
<div class="loader">
    <div></div>
</div>
<div class="content">

    <style>
        .content{
            display: none;
        }
        .loader{
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            background-color: #161616;
            position: absolute;
        }
        .loader>div{
            height: 100px;
            width:100px;
            border: 15px solid #45474b;
            border-top-color: #F10051;
            position: absolute;
            margin:auto;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 50%;
            animation: spin 1s infinite linear;
        }
        @keyframes spin {
            100%{
                transform: rotate(360deg);
            }

        }
        #bubbleChart {
            width: 100%;
            height: 700px;
        }
        #barChart {
            width: 100%;
            height: 700px;
        }
    </style>
    <script>
        $(window).on('load', function(){
            $(".loader").fadeOut(1000);
            $(".content").fadeIn(1000);
        });
    </script>
    <body>
    @yield('body')

    @livewireScripts

    <section id="loading">
        <div id="loading-content"></div>
    </section>
    </body>
</html>
