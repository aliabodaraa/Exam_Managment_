<!doctype html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Exam Time Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">{{-- added --}}
    <link rel="stylesheet" href="{!! url('assets/css/popUp_cubic.css') !!}">
    <link rel="stylesheet" href="{!! url('assets/css/globalStyle.css') !!}">

    <!-- Custom styles for this template -->
    {{-- <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet"> --}}
    <style>
      @font-face {
          font-family: 'myFirstFontHeading';
          src: url("assets/fonts/TheSansArab-Black.ttf");
      }

      @font-face {
          font-family: 'myFirstFontNormal';
          src: url("assets/fonts/TheSansArab-Bold_0.ttf");
      }

      h1,h2.h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6{
          font-family: 'myFirstFontHeading';
      }
      body{
        font-family: 'myFirstFontNormal',sans-serif ;
      }
      *{
        font-family: 'myFirstFontNormal';
      }
      a{
        text-decoration: none;
      }
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
    /* .Active{
        border-radius: 5px;
        color: black;
        background-color:#004871;
    } */
    header ul li{
      margin-left: 4px;
    }
   header ul li:hover{
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



/* checkbox style */
@charset "UTF-8";
.toggler-wrapper {
  display: block;
  width: 45px;
  height: 25px;
  cursor: pointer;
  position: relative;
}

.toggler-wrapper input[type="checkbox"] {
  display: none;
}

.toggler-wrapper input[type="checkbox"]:checked+.toggler-slider {
  background-color: #44cc66;
}

.toggler-wrapper .toggler-slider {
  background-color: #ccc;
  position: absolute;
  border-radius: 100px;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
}

.toggler-wrapper .toggler-knob {
  position: absolute;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
}


/*--------------------------------------------------------------
3.0 Effects Styles
--------------------------------------------------------------*/


/*Style 1*/

.toggler-wrapper.style-1 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-1 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
}


/*Style 2*/

.toggler-wrapper.style-2 {
  width: 67.5px;
}

.toggler-wrapper.style-2 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
  opacity: 0.4;
}

.toggler-wrapper.style-2 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  opacity: 1;
}

.toggler-wrapper.style-2 .toggler-knob {
  position: relative;
  height: 100%;
}

.toggler-wrapper.style-2 .toggler-knob:before {
  content: 'Off';
  position: absolute;
  top: 50%;
  left: 5px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 900;
  color: white;
}

.toggler-wrapper.style-2 .toggler-knob:after {
  content: 'On';
  position: absolute;
  top: 50%;
  right: 5px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  color: white;
  opacity: 0.4;
}


/*Style 3*/

.toggler-wrapper.style-3 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-3 .toggler-knob {
  width: calc(25px + 6px);
  height: calc(25px + 6px);
  border-radius: 50%;
  left: -3px;
  top: -3px;
  background-color: #fff;
  -webkit-box-shadow: 0 2px 6px rgba(153, 153, 153, 0.75);
  box-shadow: 0 2px 6px rgba(153, 153, 153, 0.75);
}


/*Style 4*/

.toggler-wrapper.style-4 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-4 .toggler-knob {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  left: 0;
  top: 0;
  background-color: #fff;
  -webkit-box-shadow: 0 2px 6px rgba(153, 153, 153, 0.75);
  box-shadow: 0 2px 6px rgba(153, 153, 153, 0.75);
}


/*Style 5*/

.toggler-wrapper.style-5 input[type="checkbox"]:checked+.toggler-slider {
  background-color: #ccc;
}

.toggler-wrapper.style-5 input[type="checkbox"]:checked+.toggler-slider:before {
  background-color: #e6e6e6;
}

.toggler-wrapper.style-5 input[type="checkbox"]:checked+.toggler-slider:after {
  background-color: #44cc66;
}

.toggler-wrapper.style-5 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-5 .toggler-slider:before {
  content: '';
  position: absolute;
  top: 50%;
  left: -12.5px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  width: 8.3333333333px;
  height: 8.3333333333px;
  border-radius: 50%;
  background-color: #b3b3b3;
}

.toggler-wrapper.style-5 .toggler-slider:after {
  content: '';
  position: absolute;
  top: 50%;
  right: -17.5px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  width: 12.5px;
  height: 12.5px;
  border-radius: 50%;
  background-color: #e6e6e6;
}

.toggler-wrapper.style-5 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
}


/*Style 6*/

.toggler-wrapper.style-6 {
  width: 54px;
  -webkit-box-shadow: 0 0.07em 0.1em -0.1em rgba(0, 0, 0, 0.4) inset, 0 0.05em 0.08em -0.01em rgba(255, 255, 255, 0.7);
  box-shadow: 0 0.07em 0.1em -0.1em rgba(0, 0, 0, 0.4) inset, 0 0.05em 0.08em -0.01em rgba(255, 255, 255, 0.7);
  background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.07)), to(rgba(255, 255, 255, 0))), #ddd;
  background: linear-gradient(rgba(0, 0, 0, 0.07), rgba(255, 255, 255, 0)), #ddd;
  border-radius: 100px;
}

.toggler-wrapper.style-6 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px + 5px);
}

.toggler-wrapper.style-6 .toggler-slider {
  -webkit-box-shadow: 0 0.08em 0.15em -0.1em rgba(0, 0, 0, 0.5) inset, 0 0.05em 0.08em -0.01em rgba(255, 255, 255, 0.7), 0 0 0 0 rgba(68, 204, 102, 0.7) inset;
  box-shadow: 0 0.08em 0.15em -0.1em rgba(0, 0, 0, 0.5) inset, 0 0.05em 0.08em -0.01em rgba(255, 255, 255, 0.7), 0 0 0 0 rgba(68, 204, 102, 0.7) inset;
  background: -webkit-gradient(linear, left top, left bottom, from(rgba(0, 0, 0, 0.07)), to(rgba(255, 255, 255, 0.1))), #d0d0d0;
  background: linear-gradient(rgba(0, 0, 0, 0.07), rgba(255, 255, 255, 0.1)), #d0d0d0;
  top: 5px;
  left: 5px;
  width: calc(100% - 10px);
  height: calc(100% - 10px);
}

.toggler-wrapper.style-6 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: calc(3px - 5px);
  top: calc(3px - 5px);
  -webkit-box-shadow: 0 0.1em 0.15em -0.05em rgba(255, 255, 255, 0.9) inset, 0 0.2em 0.2em -0.12em rgba(0, 0, 0, 0.5);
  box-shadow: 0 0.1em 0.15em -0.05em rgba(255, 255, 255, 0.9) inset, 0 0.2em 0.2em -0.12em rgba(0, 0, 0, 0.5);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(10%, #f5f5f5), to(#eeeeee));
  background: linear-gradient(#f5f5f5 10%, #eeeeee);
}


/*Style 7*/

.toggler-wrapper.style-7 input[type="checkbox"]:checked+.toggler-slider {
  background-color: white;
}

.toggler-wrapper.style-7 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-7 .toggler-slider {
  background-color: white;
  -webkit-box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  border-radius: 5px;
}

.toggler-wrapper.style-7 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 5px;
  left: 3px;
  top: 3px;
  background-color: #e6e6e6;
}


/*Style 8*/

.toggler-wrapper.style-8 input[type="checkbox"]:checked+.toggler-slider {
  background-color: #d9d9d9;
}

.toggler-wrapper.style-8 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background: conic-gradient(#43A047, #255827);
  -webkit-transform: rotate(360deg);
  transform: rotate(360deg);
}

.toggler-wrapper.style-8 .toggler-slider {
  background-color: #d9d9d9;
}

.toggler-wrapper.style-8 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background: conic-gradient(#E53935, #9f1815);
}


/*Style 9*/

.toggler-wrapper.style-9 input[type="checkbox"]:checked+.toggler-slider {
  background-color: transparent;
}

.toggler-wrapper.style-9 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-9 .toggler-slider {
  background-color: transparent;
  border: 2px solid #b3b3b3;
}

.toggler-wrapper.style-9 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #b3b3b3;
}


/*Style 10*/

.toggler-wrapper.style-10 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-10 .toggler-slider {
  background-color: #ccc;
}

.toggler-wrapper.style-10 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  border: 2px solid #fff;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}


/*Style 11*/

.toggler-wrapper.style-11 input[type="checkbox"]:checked+.toggler-slider:after {
  content: 'On';
}

.toggler-wrapper.style-11 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-11 .toggler-slider:after {
  content: 'Off';
  position: absolute;
  top: 50%;
  right: -25px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0.7;
}

.toggler-wrapper.style-11 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
}


/*Style 12*/

.toggler-wrapper.style-12 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-image: url(../img/lock-fill.svg);
}

.toggler-wrapper.style-12 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
  background-image: url(../img/lock-unlock-fill.svg);
  background-repeat: no-repeat;
  background-size: 80%;
  background-position: center;
}


/*Style 13*/

.toggler-wrapper.style-13 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-13 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  content: 'On';
}

.toggler-wrapper.style-13 .toggler-knob {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  left: 0;
  top: 0;
  background-color: #fff;
  -webkit-box-shadow: 0 2px 6px rgba(153, 153, 153, 0.75);
  box-shadow: 0 2px 6px rgba(153, 153, 153, 0.75);
}

.toggler-wrapper.style-13 .toggler-knob:after {
  content: 'Off';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  font-size: 65%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0.7;
}


/*Style 14*/

.toggler-wrapper.style-14 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 18.75px);
}

.toggler-wrapper.style-14 .toggler-knob {
  width: 12.5px;
  height: 12.5px;
  top: 50%;
  left: 6.25px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  border-radius: 50%;
  background-color: #fff;
}


/*Style 15*/

.toggler-wrapper.style-15 {
  left: 30px;
}

.toggler-wrapper.style-15 input[type="checkbox"]:checked+.toggler-slider:before {
  opacity: 0.5;
}

.toggler-wrapper.style-15 input[type="checkbox"]:checked+.toggler-slider:after {
  opacity: 1;
}

.toggler-wrapper.style-15 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-15 .toggler-slider:before {
  content: 'Off';
  position: absolute;
  top: 50%;
  left: -30px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
}

.toggler-wrapper.style-15 .toggler-slider:after {
  content: 'On';
  position: absolute;
  top: 50%;
  right: -25px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0.5;
}

.toggler-wrapper.style-15 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
}


/*Style 16*/

.toggler-wrapper.style-16 input[type="checkbox"]:checked+.toggler-slider {
  background-color: white;
}

.toggler-wrapper.style-16 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-16 .toggler-slider {
  background-color: white;
  -webkit-box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  border-radius: 0;
}

.toggler-wrapper.style-16 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  left: 3px;
  top: 3px;
  background-color: #e6e6e6;
}


/*Style 17*/

.toggler-wrapper.style-17 input[type="checkbox"]:checked+.toggler-slider {
  background-color: white;
}

.toggler-wrapper.style-17 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-17 .toggler-slider {
  background-color: transparent;
  border-radius: 0;
  border: 2px solid #b3b3b3;
}

.toggler-wrapper.style-17 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  left: 3px;
  top: 3px;
  background-color: #b3b3b3;
}


/*Style 18*/

.toggler-wrapper.style-18 input[type="checkbox"]:checked+.toggler-slider {
  background-color: #44cc66;
}

.toggler-wrapper.style-18 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
}

.toggler-wrapper.style-18 .toggler-slider {
  -webkit-box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  border-radius: 0;
}

.toggler-wrapper.style-18 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  left: 3px;
  top: 3px;
  background-color: white;
}


/*Style 19*/

.toggler-wrapper.style-19 input[type="checkbox"]:checked+.toggler-slider {
  background-color: white;
  border-color: #44cc66;
}

.toggler-wrapper.style-19 input[type="checkbox"]:checked+.toggler-slider:after {
  content: 'Yes';
}

.toggler-wrapper.style-19 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-19 .toggler-slider {
  background-color: transparent;
  border-radius: 0;
  border: 2px solid #b3b3b3;
}

.toggler-wrapper.style-19 .toggler-slider:after {
  content: 'No';
  position: absolute;
  top: 50%;
  right: -30px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0.7;
}

.toggler-wrapper.style-19 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  left: 3px;
  top: 3px;
  background-color: #b3b3b3;
}


/*Style 20*/

.toggler-wrapper.style-20 {
  width: 81px;
  text-align: center;
}

.toggler-wrapper.style-20 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  background-image: url(../img/check-fill.svg);
}

.toggler-wrapper.style-20 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
  opacity: 0.4;
}

.toggler-wrapper.style-20 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  opacity: 1;
}

.toggler-wrapper.style-20 .toggler-slider {
  background-color: #eb4f37;
}

.toggler-wrapper.style-20 .toggler-knob {
  position: relative;
  height: 100%;
  background-image: url(../img/close-fill.svg);
  background-repeat: no-repeat;
  background-position: center;
  width: 20px;
  display: inline-block;
  left: -2px;
}

.toggler-wrapper.style-20 .toggler-knob:before {
  content: 'No';
  position: absolute;
  top: 50%;
  left: -20px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  color: white;
}

.toggler-wrapper.style-20 .toggler-knob:after {
  content: 'Yes';
  position: absolute;
  top: 50%;
  right: -23px;
  -webkit-transform: translateY(-50%);
  transform: translateY(-50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  color: white;
  opacity: 0.4;
}


/*Style 21*/

.toggler-wrapper.style-21 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-image: url(../img/shut-down-line-on.svg);
}

.toggler-wrapper.style-21 .toggler-slider {
  background-color: #eb4f37;
}

.toggler-wrapper.style-21 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
  background-image: url(../img/shut-down-line-off.svg);
  background-repeat: no-repeat;
  background-position: center;
}


/*Style 22*/

.toggler-wrapper.style-22 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  -webkit-transform: scale(1);
  transform: scale(1);
}

.toggler-wrapper.style-22 .toggler-slider {
  background-color: #eb4f37;
}

.toggler-wrapper.style-22 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  background-color: white;
  -webkit-transform: scale(0.5);
  transform: scale(0.5);
}


/*Style 23*/

.toggler-wrapper.style-23 input[type="checkbox"]:checked+.toggler-slider {
  background-color: transparent;
  border-color: #44cc66;
}

.toggler-wrapper.style-23 input[type="checkbox"]:checked+.toggler-slider:before {
  -webkit-transform: translateY(0);
  transform: translateY(0);
  opacity: 0.7;
}

.toggler-wrapper.style-23 input[type="checkbox"]:checked+.toggler-slider:after {
  opacity: 0;
  -webkit-transform: translateY(20px);
  transform: translateY(20px);
}

.toggler-wrapper.style-23 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-23 .toggler-slider {
  background-color: transparent;
  border: 2px solid #eb4f37;
}

.toggler-wrapper.style-23 .toggler-slider:before {
  content: 'Accept';
  position: absolute;
  top: 8px;
  right: -60px;
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  -webkit-transform: translateY(-20px);
  transform: translateY(-20px);
}

.toggler-wrapper.style-23 .toggler-slider:after {
  content: 'Decline';
  position: absolute;
  top: 8px;
  right: -60px;
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0.7;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
}

.toggler-wrapper.style-23 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #eb4f37;
}


/*Style 24*/

.toggler-wrapper.style-24 {
  width: 90px;
}

.toggler-wrapper.style-24 input[type="checkbox"]:checked+.toggler-slider {
  border-color: #44cc66;
}

.toggler-wrapper.style-24 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 37.5px);
}

.toggler-wrapper.style-24 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  content: 'On';
}

.toggler-wrapper.style-24 .toggler-slider {
  border-radius: 0;
  background-color: #eb4f37;
  border: 2px solid #eb4f37;
}

.toggler-wrapper.style-24 .toggler-knob {
  width: 37.5px;
  height: 25px;
  border-radius: 0;
  left: 0;
  top: 0;
  background-color: #fff;
}

.toggler-wrapper.style-24 .toggler-knob:after {
  content: 'Off';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  opacity: 0.7;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
}


/*Style 25*/

.toggler-wrapper.style-25 input[type="checkbox"]:checked+.toggler-slider {
  background-color: white;
}

.toggler-wrapper.style-25 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
  background-image: url(../img/check-fill.svg);
}

.toggler-wrapper.style-25 .toggler-slider {
  background-color: white;
  -webkit-box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  box-shadow: 2px 4px 8px rgba(200, 200, 200, 0.5);
  border-radius: 5px;
}

.toggler-wrapper.style-25 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 5px;
  left: 3px;
  top: 3px;
  background-color: #ccc;
  background-image: url(../img/close-fill.svg);
  background-repeat: no-repeat;
  background-position: center;
}


/*Style 26*/

.toggler-wrapper.style-26 input[type="checkbox"]:checked+.toggler-slider {
  background-color: #d9d9d9;
}

.toggler-wrapper.style-26 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  left: calc(100% - 19px - 3px);
  background-color: #44cc66;
}

.toggler-wrapper.style-26 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  content: '1';
}

.toggler-wrapper.style-26 .toggler-slider {
  background-color: #d9d9d9;
}

.toggler-wrapper.style-26 .toggler-knob {
  width: calc(25px - 6px);
  height: calc(25px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #eb4f37;
}

.toggler-wrapper.style-26 .toggler-knob:after {
  content: '0';
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  font-size: 75%;
  text-transform: uppercase;
  font-weight: 500;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  color: white;
}


/*Style 27*/

.toggler-wrapper.style-27 {
  width: 54px;
  height: 30px;
}

.toggler-wrapper.style-27 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
  left: -100%;
}

.toggler-wrapper.style-27 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  right: 3px;
}

.toggler-wrapper.style-27 .toggler-knob {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.toggler-wrapper.style-27 .toggler-knob:before {
  content: 'No';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}

.toggler-wrapper.style-27 .toggler-knob:after {
  content: 'Yes';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  right: -100%;
  top: 3px;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}


/*Style 28*/

.toggler-wrapper.style-28 {
  width: 54px;
  height: 30px;
}

.toggler-wrapper.style-28 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
  top: -100%;
}

.toggler-wrapper.style-28 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  top: 3px;
}

.toggler-wrapper.style-28 .toggler-knob {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.toggler-wrapper.style-28 .toggler-knob:before {
  content: 'No';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}

.toggler-wrapper.style-28 .toggler-knob:after {
  content: 'Yes';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  right: 3px;
  top: -100%;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}


/*Style 29*/

.toggler-wrapper.style-29 {
  width: 54px;
  height: 30px;
}

.toggler-wrapper.style-29 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
  top: 100%;
}

.toggler-wrapper.style-29 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  top: 3px;
}

.toggler-wrapper.style-29 .toggler-knob {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.toggler-wrapper.style-29 .toggler-knob:before {
  content: 'No';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}

.toggler-wrapper.style-29 .toggler-knob:after {
  content: 'Yes';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  right: 3px;
  top: 100%;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}


/*Style 30*/

.toggler-wrapper.style-30 {
  width: 54px;
  height: 30px;
  -webkit-perspective: 100px;
  perspective: 100px;
}

.toggler-wrapper.style-30 input[type="checkbox"]:checked+.toggler-slider {
  -webkit-transform: rotateY(180deg);
  transform: rotateY(180deg);
  -webkit-transition-delay: 300ms;
  transition-delay: 300ms;
}

.toggler-wrapper.style-30 input[type="checkbox"]:checked+.toggler-slider .toggler-knob {
  -webkit-transform: rotateY(180deg);
  transform: rotateY(180deg);
  -webkit-transition-delay: 300ms;
  transition-delay: 300ms;
}

.toggler-wrapper.style-30 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:before {
  left: -100%;
}

.toggler-wrapper.style-30 input[type="checkbox"]:checked+.toggler-slider .toggler-knob:after {
  right: 3px;
}

.toggler-wrapper.style-30 .toggler-knob {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

.toggler-wrapper.style-30 .toggler-knob:before {
  content: 'No';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  left: 3px;
  top: 3px;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}

.toggler-wrapper.style-30 .toggler-knob:after {
  content: 'Yes';
  position: absolute;
  width: calc(30px - 6px);
  height: calc(30px - 6px);
  border-radius: 50%;
  right: -100%;
  top: 3px;
  background-color: #fff;
  -webkit-transition: all 300ms ease;
  transition: all 300ms ease;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  font-size: 75%;
  font-weight: 500;
}

/@import url("https://fonts.googleapis.com/css?family=Roboto:300,500,700,900");
body {
  background-color: #fcfcfc;
  font-weight: 300;
  color: #333;
}

.buttons-wrapper>div {
  display: inline-block;
  background-color: #e8e8e8;
  padding: 20px;
  margin: 5px;
  width: 20%;
  border-radius: 8px;
  border: 1px solid rgba(200, 200, 200, 0.1);
  box-shadow: 2px 2px 7px rgba(80, 80, 80, 0.1);
}

.buttons-wrapper {
  margin: 5%;
}

.img-responsive {
  display: block;
  max-width: 100%;
  height: auto;
}

.text-center {
  text-align: center;
}

header {
  padding: 5px 10px 40px 10px;
  margin-bottom: 20px;
}

header h1 {
  font-size: 50px;
  font-weight: 900;
}

header p {
  color: #999;
}

header strong {
  margin-top: 10px;
  display: inline-block;
  color: #3bc7ea;
}

section.row {
  display: flex;
  margin-bottom: 4em;
  align-items: flex-end;
}

section.row h2 {
  font-size: 34px;
  margin-bottom: 5px;
  color: #ccc;
}

.badge {
  font-size: 75%;
  /*background-color: #f2eee0;*/
  display: inline-block;
  /*padding: 3px 8px;*/
  margin: 10px 0px;
  border-radius: 4px;
}

.helper .putin {
  margin-bottom: 6em;
}


/*Normalize*/


/*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */


/* Document
   ========================================================================== */


/**
 * 1. Correct the line height in all browsers.
 * 2. Prevent adjustments of font size after orientation changes in iOS.
 */

html {
  line-height: 1.15;
  /* 1 */
  -webkit-text-size-adjust: 100%;
  /* 2 */
}


/* Sections
   ========================================================================== */


/**
 * Remove the margin in all browsers.
 */

body {
  margin: 0;
}


/**
 * Render the `main` element consistently in IE.
 */

main {
  display: block;
}


/**
 * Correct the font size and margin on `h1` elements within `section` and
 * `article` contexts in Chrome, Firefox, and Safari.
 */

h1 {
  font-size: 2em;
  margin: 0.67em 0;
}


/* Grouping content
   ========================================================================== */


/**
 * 1. Add the correct box sizing in Firefox.
 * 2. Show the overflow in Edge and IE.
 */

hr {
  box-sizing: content-box;
  /* 1 */
  height: 0;
  /* 1 */
  overflow: visible;
  /* 2 */
}


/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */

pre {
  /* 1 */
  font-size: 1em;
  /* 2 */
}


/* Text-level semantics
   ========================================================================== */


/**
 * Remove the gray background on active links in IE 10.
 */

a {
  background-color: transparent;
}


/**
 * 1. Remove the bottom border in Chrome 57-
 * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
 */

abbr[title] {
  border-bottom: none;
  /* 1 */
  text-decoration: underline;
  /* 2 */
  text-decoration: underline dotted;
  /* 2 */
}


/**
 * Add the correct font weight in Chrome, Edge, and Safari.
 */

b,
strong {
  font-weight: bolder;
}


/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */

code,
kbd,
samp {
  /* 1 */
  font-size: 1em;
  /* 2 */
}


/**
 * Add the correct font size in all browsers.
 */

small {
  font-size: 80%;
}


/**
 * Prevent `sub` and `sup` elements from affecting the line height in
 * all browsers.
 */

sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
}

sub {
  bottom: -0.25em;
}

sup {
  top: -0.5em;
}


/* Embedded content
   ========================================================================== */


/**
 * Remove the border on images inside links in IE 10.
 */

img {
  border-style: none;
}


/* Forms
   ========================================================================== */


/**
 * 1. Change the font styles in all browsers.
 * 2. Remove the margin in Firefox and Safari.
 */

button,
input,
optgroup,
select,
textarea {
  /* 1 */
  font-size: 100%;
  /* 1 */
  line-height: 1.15;
  /* 1 */
  margin: 0;
  /* 2 */
}


/**
 * Show the overflow in IE.
 * 1. Show the overflow in Edge.
 */

button,
input {
  /* 1 */
  overflow: visible;
}


/**
 * Remove the inheritance of text transform in Edge, Firefox, and IE.
 * 1. Remove the inheritance of text transform in Firefox.
 */

button,
select {
  /* 1 */
  text-transform: none;
}


/**
 * Correct the inability to style clickable types in iOS and Safari.
 */

button,
[type="button"],
[type="reset"],
[type="submit"] {
  -webkit-appearance: button;
}


/**
 * Remove the inner border and padding in Firefox.
 */

button::-moz-focus-inner,
[type="button"]::-moz-focus-inner,
[type="reset"]::-moz-focus-inner,
[type="submit"]::-moz-focus-inner {
  border-style: none;
  padding: 0;
}


/**
 * Restore the focus styles unset by the previous rule.
 */

button:-moz-focusring,
[type="button"]:-moz-focusring,
[type="reset"]:-moz-focusring,
[type="submit"]:-moz-focusring {
  outline: 1px dotted ButtonText;
}


/**
 * Correct the padding in Firefox.
 */

fieldset {
  padding: 0.35em 0.75em 0.625em;
}


/**
 * 1. Correct the text wrapping in Edge and IE.
 * 2. Correct the color inheritance from `fieldset` elements in IE.
 * 3. Remove the padding so developers are not caught out when they zero out
 *    `fieldset` elements in all browsers.
 */

legend {
  box-sizing: border-box;
  /* 1 */
  color: inherit;
  /* 2 */
  display: table;
  /* 1 */
  max-width: 100%;
  /* 1 */
  padding: 0;
  /* 3 */
  white-space: normal;
  /* 1 */
}


/**
 * Add the correct vertical alignment in Chrome, Firefox, and Opera.
 */

progress {
  vertical-align: baseline;
}


/**
 * Remove the default vertical scrollbar in IE 10+.
 */

textarea {
  overflow: auto;
}


/**
 * 1. Add the correct box sizing in IE 10.
 * 2. Remove the padding in IE 10.
 */

[type="checkbox"],
[type="radio"] {
  box-sizing: border-box;
  /* 1 */
  padding: 0;
  /* 2 */
}


/**
 * Correct the cursor style of increment and decrement buttons in Chrome.
 */

[type="number"]::-webkit-inner-spin-button,
[type="number"]::-webkit-outer-spin-button {
  height: auto;
}


/**
 * 1. Correct the odd appearance in Chrome and Safari.
 * 2. Correct the outline style in Safari.
 */

[type="search"] {
  -webkit-appearance: textfield;
  /* 1 */
  outline-offset: -2px;
  /* 2 */
}


/**
 * Remove the inner padding in Chrome and Safari on macOS.
 */

[type="search"]::-webkit-search-decoration {
  -webkit-appearance: none;
}


/**
 * 1. Correct the inability to style clickable types in iOS and Safari.
 * 2. Change font properties to `inherit` in Safari.
 */

::-webkit-file-upload-button {
  -webkit-appearance: button;
  /* 1 */
  font: inherit;
  /* 2 */
}


/* Interactive
   ========================================================================== */


/*
 * Add the correct display in Edge, IE 10+, and Firefox.
 */

details {
  display: block;
}


/*
 * Add the correct display in all browsers.
 */

summary {
  display: list-item;
}


/* Misc
   ========================================================================== */


/**
 * Add the correct display in IE 10+.
 */

template {
  display: none;
}


/**
 * Add the correct display in IE 10.
 */

[hidden] {
  display: none;
}


/*Utility*/


/* Basscss Margin */

.m0 {
  margin: 0;
}

.mt0 {
  margin-top: 0;
}

.mr0 {
  margin-right: 0;
}

.mb0 {
  margin-bottom: 0;
}

.ml0 {
  margin-left: 0;
}

.mx0 {
  margin-left: 0;
  margin-right: 0;
}

.my0 {
  margin-top: 0;
  margin-bottom: 0;
}

.m1 {
  margin: var(--space-1);
}

.mt1 {
  margin-top: var(--space-1);
}

.mr1 {
  margin-right: var(--space-1);
}

.mb1 {
  margin-bottom: var(--space-1);
}

.ml1 {
  margin-left: var(--space-1);
}

.mx1 {
  margin-left: var(--space-1);
  margin-right: var(--space-1);
}

.my1 {
  margin-top: var(--space-1);
  margin-bottom: var(--space-1);
}

.m2 {
  margin: var(--space-2);
}

.mt2 {
  margin-top: var(--space-2);
}

.mr2 {
  margin-right: var(--space-2);
}

.mb2 {
  margin-bottom: var(--space-2);
}

.ml2 {
  margin-left: var(--space-2);
}

.mx2 {
  margin-left: var(--space-2);
  margin-right: var(--space-2);
}

.my2 {
  margin-top: var(--space-2);
  margin-bottom: var(--space-2);
}

.m3 {
  margin: var(--space-3);
}

.mt3 {
  margin-top: var(--space-3);
}

.mr3 {
  margin-right: var(--space-3);
}

.mb3 {
  margin-bottom: var(--space-3);
}

.ml3 {
  margin-left: var(--space-3);
}

.mx3 {
  margin-left: var(--space-3);
  margin-right: var(--space-3);
}

.my3 {
  margin-top: var(--space-3);
  margin-bottom: var(--space-3);
}

.m4 {
  margin: var(--space-4);
}

.mt4 {
  margin-top: var(--space-4);
}

.mr4 {
  margin-right: var(--space-4);
}

.mb4 {
  margin-bottom: var(--space-4);
}

.ml4 {
  margin-left: var(--space-4);
}

.mx4 {
  margin-left: var(--space-4);
  margin-right: var(--space-4);
}

.my4 {
  margin-top: var(--space-4);
  margin-bottom: var(--space-4);
}

.mxn1 {
  margin-left: calc(var(--space-1) * -1);
  margin-right: calc(var(--space-1) * -1);
}

.mxn2 {
  margin-left: calc(var(--space-2) * -1);
  margin-right: calc(var(--space-2) * -1);
}

.mxn3 {
  margin-left: calc(var(--space-3) * -1);
  margin-right: calc(var(--space-3) * -1);
}

.mxn4 {
  margin-left: calc(var(--space-4) * -1);
  margin-right: calc(var(--space-4) * -1);
}

.m-auto {
  margin: auto;
}

.mt-auto {
  margin-top: auto;
}

.mr-auto {
  margin-right: auto;
}

.mb-auto {
  margin-bottom: auto;
}

.ml-auto {
  margin-left: auto;
}

.mx-auto {
  margin-left: auto;
  margin-right: auto;
}

.my-auto {
  margin-top: auto;
  margin-bottom: auto;
}

:root {
  --space-1: .5rem;
  --space-2: 1rem;
  --space-3: 2rem;
  --space-4: 4rem;
}


/* Basscss Padding */

.p0 {
  padding: 0;
}

.pt0 {
  padding-top: 0;
}

.pr0 {
  padding-right: 0;
}

.pb0 {
  padding-bottom: 0;
}

.pl0 {
  padding-left: 0;
}

.px0 {
  padding-left: 0;
  padding-right: 0;
}

.py0 {
  padding-top: 0;
  padding-bottom: 0;
}

.p1 {
  padding: var(--space-1);
}

.pt1 {
  padding-top: var(--space-1);
}

.pr1 {
  padding-right: var(--space-1);
}

.pb1 {
  padding-bottom: var(--space-1);
}

.pl1 {
  padding-left: var(--space-1);
}

.py1 {
  padding-top: var(--space-1);
  padding-bottom: var(--space-1);
}

.px1 {
  padding-left: var(--space-1);
  padding-right: var(--space-1);
}

.p2 {
  padding: var(--space-2);
}

.pt2 {
  padding-top: var(--space-2);
}

.pr2 {
  padding-right: var(--space-2);
}

.pb2 {
  padding-bottom: var(--space-2);
}

.pl2 {
  padding-left: var(--space-2);
}

.py2 {
  padding-top: var(--space-2);
  padding-bottom: var(--space-2);
}

.px2 {
  padding-left: var(--space-2);
  padding-right: var(--space-2);
}

.p3 {
  padding: var(--space-3);
}

.pt3 {
  padding-top: var(--space-3);
}

.pr3 {
  padding-right: var(--space-3);
}

.pb3 {
  padding-bottom: var(--space-3);
}

.pl3 {
  padding-left: var(--space-3);
}

.py3 {
  padding-top: var(--space-3);
  padding-bottom: var(--space-3);
}

.px3 {
  padding-left: var(--space-3);
  padding-right: var(--space-3);
}

.p4 {
  padding: var(--space-4);
}

.pt4 {
  padding-top: var(--space-4);
}

.pr4 {
  padding-right: var(--space-4);
}

.pb4 {
  padding-bottom: var(--space-4);
}

.pl4 {
  padding-left: var(--space-4);
}

.py4 {
  padding-top: var(--space-4);
  padding-bottom: var(--space-4);
}

.px4 {
  padding-left: var(--space-4);
  padding-right: var(--space-4);
}

/* progress style */
.progress {
    width: 100px;
    height: 100px;
    background: none;
    position: relative;
}

.progress::after {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 6px solid #eee;
  position: absolute;
  top: 0;
  left: 0;
}

.progress>span {
  width: 50%;
  height: 100%;
  overflow: hidden;
  position: absolute;
  top: 0;
  z-index: 1;
}

.progress .progress-left {
  left: 0;
}

.progress .progress-bar {
  width: 100%;
  height: 100%;
  background: none;
  border-width: 6px;
  border-style: solid;
  position: absolute;
  top: 0;
}

.progress .progress-left .progress-bar {
  left: 100%;
  border-top-right-radius: 80px;
  border-bottom-right-radius: 80px;
  border-left: 0;
  -webkit-transform-origin: center left;
  transform-origin: center left;
}

.progress .progress-right {
  right: 0;
}

.progress .progress-right .progress-bar {
  left: -100%;
  border-top-left-radius: 80px;
  border-bottom-left-radius: 80px;
  border-right: 0;
  -webkit-transform-origin: center right;
  transform-origin: center right;
}

.progress .progress-value {
  position: absolute;
  top: 0;
  left: 0;
}

.rounded-lg {
  border-radius: 1rem;
}

.text-gray {
  color: #aaa;
}

div.h4 {
  line-height: 1rem;
}
/* progress style */
#nav_btn_internal{
  display: contents;
}
#Tishreen_University_logo{
  width: 50px;
  height: 50px;
  position: absolute;
  left: -86px;
  top: -3px;
  z-index: 99999999999999999999999999999999999;
}
@media (min-width: 900px) {
  .username{
    position: absolute;
    top: 6px;right: 20px;
  }
  .faculty{
    position: absolute;
    top: 6px;left: 100px;
  }
  #nav_row{
    font-size:16px;
  }
}
/* @media (min-width: 768px) and (max-width: 1170.99px) {
 *{background-color: red}
 } */
#nav_content_internal{
  z-index: 9999999999;
}
@media (min-width: 880px) {
  #nav_btn_external,#nav_content_external, #nav_btn_internal{
    /* display: none; */
  }
  #nav{font-size:67%;font-weight: 900;}
  .username{
    position: absolute;
    top: 6px;right: 80px;
  }
  .profile-icon{
    position: absolute;
    top: 6px;right: 40px;
  }
  #nav_row > div.col-lg-4.col-sm-4.col-xs-1 > div.text-end > div.profile-icon > a > svg{
    color: white;
  }
  #nav_row > div.col-lg-4.col-sm-4.col-xs-1 > div.text-end > div.profile-icon > a > svg:hover{
    color: #888;
  }
  label{
    direction: rtl;
    float: right;
  }
  #nav_row{
    height: 55px;
  }
  #nav_content_internal{
    position: absolute;
    top: -2px;
  }
}
.user-profile-info .px-3{
          border-left: solid 1px;
          border-right: solid 1px;
          margin-left: 16px;
          margin-right: 16px;
        }
        .collect-index-btns{
          display: -webkit-inline-box;
  }
@media (max-width: 880px) {
        .faculty{
          position: absolute;
          top: 110px;right: 5px;
        }
        .username{
          position: absolute;
          top: 86px;right: 5px;
        }
        .profile-icon{
          position: absolute;
          top: 10px;left: 80px;
        }
        .collect-index-btns{
          display: flow-root;
          margin-top: 10px;
        }
        .user-profile-info{
          position: relative;
          top: 69px;    margin-top: 45px;margin-bottom: 45px;
        }
        .btns{
          display: grid;
        }
        .username{
          display: block;
            }
        #nav{
          display: list-item;
        }
        #addCourse{
          margin-bottom: 2px;
        }
        #faculty,#logout{
          float: right;
        }
}

#nav_row {
    position: fixed;
    width: 102%;
    z-index: 999999;
    padding:0px 15px;
  }
  main{
    padding: 50px;
  }
@media (max-width: 550px) {
.faculty{
    position: absolute;
    top: 0px;right: 10px;
  }
  #Tishreen_University_logo{
    text-align: center;
    top: 2px;
    width: 50px;
    height:50px;
  }
  .username{
    position: absolute;
    top: 22px;right: 10px;
  }
  #login,#nav_row{
      display: grid;
      text-align: center;
    }
}
      .Active{
        border-radius: 5px;
        color: black;
        background-color:#6c757d;
        border-color: #6c757d;
    }
    #nav > li{
        font-size: 14px;
    }
    #nav > li:hover{
        border-radius: 5px;
        color: black;
        background-color: #ffffff2b;
    }
  table tr{
    text-align: center;
  }
  input{
    direction: rtl;
  }

    </style>
</head>
<body style="<?php if(URL::full()=='http://127.0.0.1:8000')echo'
            background-image: url(http://127.0.0.1:8000/images/Exam_Time.png);
            background-repeat: no-repeat;
            background-size: cover;'?>">
  {{-- <nav class="flex bg-slate-700 text-white'}}">
    <a href="/search" class="py-4 px-6 hover:bg-slate-800 {{ (request()->routeIs('search')) ? 'bg-slate-800' : '' }}">search</a>
  </nav> --}}
    @include('layouts.partials.navbar')
    @include('layouts.partials.popUp_cubic')

    <main class="container-fluid">
        @yield('content')
    </main>

    @section("scripts")
    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>{{-- for use js in bootstrap like collapse --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"> </script>{{-- for use jQuery --}}
    <script>
      // "global" vars, built using blade
      var imagesUrl = '{{ URL::asset('/images/') }}';
  </script>
  <script>
    const navigation=document.getElementById("navigation");
    const cubicPopUp=document.getElementById("cubicPopUp");
    // cubicPopUp.style.display="block";
    // cubicPopUp.classList.add("show");
    setTimeout(() => {
          navigation.style.display="none";
          //to remove cubic after invoke the function `showPopUpCubic` afte invoke  with 400ms will removes
          cubicPopUp.style.display="none";
          cubicPopUp.classList.remove("show");
    }, 400);

      // const intializationInExamProgramModalToggle=document.getElementById("intializationInExamProgramModalToggle");
      // const initializationRoomsInAllCourses=document.getElementById("initializationRoomsInAllCourses");
      // const initializationInExamProgram=document.getElementById("initializationInExamProgram");
    //cubicPopUp
    function showPopUpCubic(){
      //fade all initialization popUp intializationInExamProgramModalToggle initializationRoomsInAllCourses initializationInExamProgram
      // intializationInExamProgramModalToggle.classList.reomve("show");
      // initializationRoomsInAllCourses.classList.reomve("show");
      // initializationInExamProgram.classList.reomve("show");
      //fade all initialization popUp intializationInExamProgramModalToggle initializationRoomsInAllCourses initializationInExamProgram

      cubicPopUp.classList.add("show");
      cubicPopUp.style.display="block";
    }
</script>
    <script src="{!! url('assets/js/users.js') !!}"></script>
    <script src="{!! url('assets/js/courses.js') !!}"></script>
    <script src="{!! url('assets/js/rooms.js') !!}"></script>
    <script src="{!! url('assets/js/courses_edit.js') !!}"></script>
    <script src="{!! url('assets/js/courses_room_edit.js') !!}"></script>
    <script src="{!! url('assets/js/progress.js') !!}"></script>
    <script src="{!! url('assets/js/scrollTopDown.js') !!}"></script>
    <script src="{!! url('assets/js/rotation_date_starting_ending.js') !!}"></script>
    @show
  </body>
</html>
