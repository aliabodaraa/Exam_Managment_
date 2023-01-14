<div class="modal fade" id="intializationInExamProgramModalToggle" aria-hidden="true" aria-labelledby="intializationInExamProgramModalToggle" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {{-- @dd($sort_form) --}}
        <div class="modal-header">
          <h5 class="modal-title" id="intializationInExamProgramModalToggle">
            <b>
              {{$header_text}}
            </b>
        </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{$description}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a href="{{route($route_info[0],['rotation'=>$route_info[1]])}}" class='btn btn-danger' onclick="showPopUpCubic()">تهيئة</a>
        </div>
      </div>
    </div>
  </div>