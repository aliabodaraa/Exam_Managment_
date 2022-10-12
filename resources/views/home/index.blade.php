@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        @auth
            <h2>مرحبا {{ auth()->user()->username }}</h2>
            <p class="lead"></p>
            @if(!$observations_number_in_latest_rotation && auth()->user()->number_of_observation && auth()->user()->is_active && !auth()->user()->temporary_role)
                <div class="alert text-black alert-info" role="alert" style="margin-top: 20px;">
                    <p class="lead">لم يتم تعيين المراقبات الى الان يمكنك انشاء اعتراضات او تعديلها حتى تاريخ {{ App\Models\Rotation::latest()->get()[0]->end_date }}</p>
                    <hr>
                    <p class="mb-0 lead">بعد تجاوز التاريخ السابق لا يمكنك تعديل اعتراضاتك</p>
                </div>
            @elseif(! auth()->user()->is_active  && !auth()->user()->temporary_role)
                <p class="mb-0 lead"> انت غير متاح في الدورة الأخيرة /{{ App\Models\Rotation::latest()->get()[0]->name }} / {{ App\Models\Rotation::latest()->get()[0]->year }}</p>
            @endif
        @endauth

        @guest
        <h1>Hello From My Application</h1>
        <h2>{{session('success')}}</h2>
        <p class="lead">يمكنك تسجيل الدخول و التفاعل مع الموقع بحسب دورك في كليتك<mark>Login</mark> </p>
        @endguest
    </div>
@endsection
