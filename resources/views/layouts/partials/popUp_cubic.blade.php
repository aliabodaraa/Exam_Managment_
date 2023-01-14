{{-- popS --}}
<div class="modal fade show" id="cubicPopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index:9999999999999999999999;background-color: #000000a3;">
    <div class="modal-dialog" style="margin: 300px 50%;">
              <div class="cubic row">
                 <!--Cubic Begin------------------------------>
                     <div class="rubiks-loader">
                     <div class="cube">
                         <!-- base position -->
                         <div class="face front piece row-top    col-left   yellow"></div>
                         <div class="face front piece row-top    col-center green "></div>
                         <div class="face front piece row-top    col-right  white "></div>
                         <div class="face front piece row-center col-left   blue  "></div>
                         <div class="face front piece row-center col-center green "></div>
                         <div class="face front piece row-center col-right  blue  "></div>
                         <div class="face front piece row-bottom col-left   green "></div>
                         <div class="face front piece row-bottom col-center yellow"></div>
                         <div class="face front piece row-bottom col-right  red   "></div>

                         {{-- <!-- first step: E', equator inverted --> --}}
                         <div class="face down  piece row-top    col-center green "></div>
                         <div class="face down  piece row-center col-center red   "></div>
                         <div class="face down  piece row-bottom col-center white "></div>

                         <!-- second step: M, middle -->
                         <div class="face right piece row-center col-left   yellow"></div>
                         <div class="face right piece row-center col-center green "></div>
                         <div class="face right piece row-center col-right  blue  "></div>

                         <!-- third step: L, left -->
                         <div class="face up    piece row-top    col-left   yellow"></div>
                         <div class="face up    piece row-center col-left   blue  "></div>
                         <div class="face up    piece row-bottom col-left   green "></div>

                         <!-- fourth step: D, down -->
                         <div class="face left  piece row-bottom col-left   green "></div>
                         <div class="face left  piece row-bottom col-center yellow"></div>
                         <div class="face left  piece row-bottom col-right  red   "></div>
                     </div>
                 </div>
                 <!--Cubic End------------------------------>
             </div>
        
       
     </div>
 </div>
{{-- popE --}}
{{-- popS --}}
 <div class="modal fade" id="ErrorPopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin: 300px 50%;">
              <div class="cubic row">
                 <!--Cubic Begin------------------------------>
                     <div class="rubiks-loader">
                     <div class="Error">
                   <img src="{{ asset('img/1.jpg') }}" alt="{{ __('error') }}">
                     </div>
                 </div>
                 <!--Cubic End------------------------------>
             </div>
       
       
     </div>
 </div>
{{-- popE --}}