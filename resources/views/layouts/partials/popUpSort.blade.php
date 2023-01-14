<div class="modal fade" id="sortModalToggle" aria-hidden="true" aria-labelledby="sortModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {{-- @dd($sort_form) --}}
        <div class="modal-header">
          <h5 class="modal-title" id="sortModalToggleLabel">
            <b>
              @if($name_button == "توزيع الأعضاء")
                توزيع الأعضاء على القاعات
              @elseif($name_button == "توزيع الطلاب")
                توزيع الطلاب على القاعات
              @endif
            </b>
        </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul style="text-align: end;
          list-style-type: disclosure-closed;">
          @if($name_button == "توزيع الأعضاء")
            <li>!! هل أنت متأكد أنك تريد توزيع مراقبات {{ \App\Models\Rotation::where('id',$route_info[1])->first()->name }}</li>
            <li>!! هل تأكد أنك قمت بتعديل تعيينات الأعضاء</li>
            <li>!! هل تأكدت من القاعات التي يحجزها كل مقرر</li>
          @elseif($name_button == "توزيع الطلاب")
            <li>!!  هل أنت متأكد أنك تريد توزيع الطلاب على القاعات في {{ \App\Models\Rotation::where('id',$route_info[1])->first()->name }}</li>
            <li>!! هل تأكدت أنك قمت بإضافه جميع المواد للبرنامج الإمتحاني</li>
          @endif
          </ul>
        </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary" data-bs-target="#sortModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> --}}
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form method='POST' action='{{route($route_info[0],$route_info[1])}}' id='coursesForm'>
            @csrf
              <button type='submit' class="btn btn-success" onclick="showPopUpCubic()">{{ $name_button }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>