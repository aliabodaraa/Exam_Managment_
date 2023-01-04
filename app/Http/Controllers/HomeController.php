<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;

class HomeController extends Controller
{
    public function index()
    {
        // $dept=Auth::user()->department->id;
        // $someCoursesBelongToYourDepatment=Course::with(['departments'])->whereHas('departments', function($q) use($dept){
        // $q->where('department_id', '=',$dept);})->where('year',Auth::user()->studing_year)->orderBy('created_at','ASC')->limit(3)->get();

        //$somePostsBelongToYourDepatment=Auth::user()->posts;
if(Auth::check()){
    $latest_rotation=Rotation::latest()->first();
    list($all_rotations_table, $observations_number_in_latest_rotation)=Stock::calcInfoForEachRotationForSpecificuser(Auth::user());
    if(array_key_exists($latest_rotation->id,$all_rotations_table)){
        return view('home.index', [
        'latest_rotation'=>$latest_rotation,
        'user' => Auth::user(),
        'rotations_in_lastet_rotation_table' => $all_rotations_table[$latest_rotation->id],
        'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation]);
    }else{
        return view('home.index', [
            'latest_rotation'=>$latest_rotation,
            'user' => Auth::user(),
            'rotations_in_lastet_rotation_table' => [],
            'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation]);
    }

    }else
       return view('home.index');
    }
}
