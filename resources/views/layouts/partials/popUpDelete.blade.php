<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {{-- @dd($delete_information) --}}
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel"><b>حذف {{ ($delete_information[0]=='rooms.destroy')?'الغرفة':'' }}{{ ($delete_information[0]=='users.destroy')?'الشخص':'' }}{{ ($delete_information[0]=='courses.destroy')?'المقرر':'' }}{{ ($delete_information[0]=='rotations.destroy')?'الدورة':'' }}</b></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          هل أنت متأكد انك تريد حذف {{ ($delete_information[0]=='rooms.destroy')?'الغرفة':'' }}{{ ($delete_information[0]=='users.destroy')?'الشخص':'' }}{{ ($delete_information[0]=='courses.destroy')?'المقرر':'' }}{{ ($delete_information[0]=='rotations.destroy')?'الدورة':'' }}
        </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> --}}
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          {!! Form::open(['method' => 'DELETE',
          'route' => [$delete_information[0], $delete_information[1]],
          'style'=>'display:inline']) !!}
          {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
          {!! Form::close() !!}
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