<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Educational Platform</title>

    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">

    <style>
        /* @media (min-width: 1400px){
.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
    max-width: 1581px;
}} */
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
    .Active{
        border-radius: 5px;
        color: black;
        background-color: #2ca691;
    }
    body > header > div > div > ul > li:hover{
        border-radius: 5px;
        color: black;
        background-color: #ffffff2b;
    }
      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .float-right {
        float: right;
      }

      /* course pages */
      .card{
        font-size: 26px;
        padding:0px;
        border-radius: 6px;
        border: 1px solid;
        max-width: 100%;
      }
      .card-img-top{
        border-radius: 6px;
        max-width: 100%;
        min-height: 100.8%;
        object-fit: cover;
        display: block;
        clip-path: polygon(-4px -4px, 100.4% -3px, 91.2% 102.57%, -0.8% 102.97%);
       }
      .card .col-md-4{
          display: grid;
      }
    .card .card-text small{
        float: right;
        position: relative;
        bottom: -82px;
      }

    /* scrollbar style */
    /* width */
    ::-webkit-scrollbar {
    width: .1px;
    }
    /* Track */
    ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 1px rgb(225, 225, 225);
    border-radius: 10px;
    }
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: grey;
    border-radius: 13px;
    }
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: #000;
    }
    table td.date{
        font-size: 15px;
        float: left
        padding-top: 32px;
    }
    table td.date b{
        margin-top: 25px;
        display: block;
    }
    .controll{
        display: contents;
        margin-top: -9px;
        DISPLAY:BLOCK;
    }
    table td.course .controll td.badge{
        display: table-caption;
    }
    table td.course .controll a,table td.course .controll input.btn{
        height: 21px;
        margin-left: 3px;
        padding-top: inherit;
        /* display: table-caption; */
    }
    table tr{
        border: 1px solid #f8f9fa;
        border-style: none;
    }

    </style>


    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">
</head>
<body>

    @include('layouts.partials.navbar')

    <main class="container mt-5">
        @yield('content')
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

    @section("scripts")

    @show
  </body>
</html>
