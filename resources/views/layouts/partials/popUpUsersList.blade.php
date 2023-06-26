<div class="modal fade" id="usersList" aria-hidden="true" aria-labelledby="usersListLabel" tabindex="-1" style="z-index: 999999999999">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        {{-- @dd($sort_form) --}}
        <div class="modal-header">
          <h5 class="modal-title text-center" id="usersListLabel">
            <b class="text-center">
                أعضاء كلية الهندسة المعلوماتية
            </b>
        </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @php $num_members=count(App\Models\User::all());
                $users=App\Models\User::all()->toarray();
            @endphp
          <ul style="text-align: end;float: right;
          list-style-type: disclosure-closed;">
            @for($i=0;$i<$num_members/2;$i++)
                <div class="user">
                    {{  $users[$i]["username"]}}
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <a href="#exampleModalToggle{{ $users[$i]['id'] }}" data-bs-toggle="modal" class="btn btn-danger btn-sm"  style="
                    right:4px;
                    border-radius: 62px;
                    position: relative;
                    font-size: 11px;
                    top: -12px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" style=" float:left;" viewBox="0 0 16 16">
                                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
                                              </svg></a>
                    @endif
                </div>
                <br>
                @php $name_=$users[$i]['username'];@endphp
                @include('layouts.partials.popUpDelete',['route_info' => ['users.destroy', $users[$i]['id']],'description' =>"هل أنت متأكد أنك تريد حذف $name_"])
            @endfor
          </ul>
          <ul style="text-align: end;float: left;
          list-style-type: disclosure-closed;">
            @for($i=$num_members/2;$i<$num_members;$i++)
                <div class="user">
                    {{  $users[$i]["username"]}}
                    @if(Auth::user()->temporary_role == "رئيس شعبة الامتحانات" || Auth::user()->temporary_role == "عميد")
                    <a href="#exampleModalToggle{{ $users[$i]['id'] }}" data-bs-toggle="modal" class="btn btn-danger btn-sm"  style="
                    right:4px;
                    border-radius: 62px;
                    position: relative;
                    font-size: 11px;
                    top: -12px;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill-x" style=" float:left;" viewBox="0 0 16 16">
                                                <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708Z"/>
                                              </svg></a>
                    @endif
                </div>
                <br>
                @php $name_=$users[$i]['username'];@endphp

                @include('layouts.partials.popUpDelete',['route_info' => ['users.destroy', $users[$i]['id']],'description' =>"هل أنت متأكد أنك تريد حذف $name_"])
            @endfor
        </ul>
        </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary" data-bs-target="#sortModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Open second modal</button> --}}
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
        </div>
      </div>
    </div>
  </div>
