<div class="modal fade" id="exampleModalToggle{{ isset($route_info[2])?$route_info[2]:$route_info[1] }}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {{-- @dd($route_info) --}}
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel"><b>حذف {{ ($route_info[0]=='rotations.course.delete_course_from_program')?'مقرر من البرنامج الإمتحاني':'' }}{{ ($route_info[0]=='rooms.destroy')?'الغرفة':'' }}{{ ($route_info[0]=='users.destroy')?'الشخص':'' }}{{ ($route_info[0]=='courses.destroy')?'المقرر':'' }}{{ ($route_info[0]=='rotations.destroy')?'الدورة':'' }}</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{$description}}
      </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> --}}
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          @if(!array_key_exists(2,$route_info))
            {!! Form::open(['method' => 'DELETE',
            'route' => [$route_info[0], $route_info[1]],
            'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
          @else
            {!! Form::open(['method' => 'DELETE',
            'route' => [$route_info[0], $route_info[1],$route_info[2]],
            'style'=>'display:inline']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
          @endif
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel2">Modal 2</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Hide this modal and show the first with the button below.
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">Back to first</button>
        </div>
      </div>
    </div>
  </div> --}}