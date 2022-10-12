@extends('layouts.app-master')

@section('content')

<section class="h-100 gradient-custom-2">
    <div class="py-2 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-9">
          <div class="card" style="font-size: 20px;border: 1px solid #42b19a;">
            <div class="rounded-top text-white d-flex flex-row" style="background-color: #42b19a; height:200px;">
              <div class="ms-4 mt-5 d-flex flex-column" style="width: 150px;">
                {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                  alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                  style="width: 150px; z-index: 1"> --}}
                  <img src="{{ asset('images/blank-profile-picture.webp') }}"
                  alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                  style="width: 150px; z-index: 1">
                @if(in_array($user->id, [1,auth()->user()->id]))
                  <a href={{ route("users.edit",[$user->id]) }} type="button" class="btn btn-outline-dark" data-mdb-ripple-color="dark"
                      style="z-index: 1;">
                      Edit profile
                  </a>
                @endif
              </div>
              <div class="ms-3" style="margin-top: 100px;">
                <h5>{{ $user->username }}</h5>
                <p>{{ $user->role }} <span class="badge bg-primary" style="font-size: 12px">{{ $user->temporary_role }}</span></p>
              </div>
            </div>
            <div class="p-4 text-black" style="background-color: #f8f9fa;">
              <div class="d-flex justify-content-end text-center py-1">
                <div>
                  <p class="mb-1 h6 small">
                    @if($user->is_active ==1)
                    متوفر
                    <img id="img_warning" src="{{ asset('images/success-icon.png') }}" alt="success" style="width: 20px;height: 20px;margin-left:10px">
                    @else
                    غير متوفر
                    <img id="img_warning" src="{{ asset('images/warning.png') }}" alt="danger" style="width: 20px;height: 20px;">
                    @endif
                  </p>
                  <p class="small text-muted mb-0">التواجد في أخر دورة</p>
                </div>
                <div class="px-3">
                  <p class="mb-1 h6 small">{{ $observations_number_in_latest_rotation?$observations_number_in_latest_rotation:0 }}/{{ $user->number_of_observation }}</p>
                  <p class="small text-muted mb-0"> عدد المراقبات في اخر دورة</p>
                </div>
                <div>
                  <p class="mb-1 h6 small">4</p>
                  <p class="small text-muted mb-0">عدد المواد التي يدرسها</p>
                </div>
              </div>
            </div>
            <div class="card-body p-4 text-black">
              <div class="mb-5">
                <p class="lead fw-normal mb-1">About</p>
                <div class="p-4" style="background-color: #f8f9fa;">
                  <p class="font-italic mb-1">Email : {{ $user->email }}</p>
                  @if($user->department)<p class="font-italic mb-1">Department : {{ $user->department->name }}</p>@endif
                  <p class="font-italic mb-0">Faculty : {{ $user->faculty->name }}</p>
                </div>
              </div>
              {{-- <div class="row g-2">
                <div class="col mb-2">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(112).webp"
                    alt="image 1" class="w-100 rounded-3">
                </div>
                <div class="col mb-2">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(107).webp"
                    alt="image 1" class="w-100 rounded-3">
                </div>
              </div>
              <div class="row g-2">
                <div class="col">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(108).webp"
                    alt="image 1" class="w-100 rounded-3">
                </div>
                <div class="col">
                  <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(114).webp"
                    alt="image 1" class="w-100 rounded-3">
                </div>
              </div> --}}

              {{-- d --}}
              @if($rotations_in_lastet_rotation_table)
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <p class="mb-0"><a href="{{ route('users.observations',[$user->id]) }}" class="text-muted">Show all</a></p>
                    <p class="lead fw-normal mb-0"> : المراقبات في اخر دورة </p>
                  </div>
                  <div class="card text-dark bg-dark mb-2" style="font-size: 16px;">
                    <div class="card-header" style="font-size: 26px;color:white;direction: rtl;">
                        {{ $rotations_in_lastet_rotation_table['name']}}
                        <span class="card-title badge bg-success me-1" style="font-size: 16px;">{{ $rotations_in_lastet_rotation_table['year'] }}</span>
                        <span class="card-title badge bg-secondary me-1" style="font-size: 16px;float: left;">start : {{ $rotations_in_lastet_rotation_table['start_date'] }}</span>
                        <span class="card-title badge bg-danger" style="font-size: 16px;float: left;">end : {{ $rotations_in_lastet_rotation_table['end_date'] }}</span>
                    </div>
                    <div class="card-body" style="font-size: 26px;color:white;text-align:center">
                    </div>
                    <div class="table-observations px-2">
                        <table class="table table-light table-striped">
                            <thead>
                                <tr>
                                    <th scope="col" width="15%">date</th>
                                    <th scope="col" width="15%">time</th>
                                    <th scope="col" width="15%">roleIn</th>
                                    <th scope="col" width="15%">course_name</th>
                                    <th scope="col" width="15%">current room_name</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($rotations_in_lastet_rotation_table['observations'] as $observation_table)
                                <tr class="table-active">
                                    <td>{{ $observation_table['date']}}</td>
                                    <td>{{ $observation_table['time'] }}</td>
                                    <td>{{ $observation_table['roleIn'] }}</td>
                                    <td>{{ $observation_table['course_name'] }}</td>
                                    <td>{{ $observation_table['room_name'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
              {{-- d --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @endsection