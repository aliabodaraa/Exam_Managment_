<?php

namespace App\Http\Controllers;
use App\Models\Course;
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
    list($rotations_table, $observations_number_in_latest_rotation)=Stock::calcInfoForEachRotationForSpecificuser(Auth::user());
       return view('home.index', ['rotations_table' => $rotations_table,
       'observations_number_in_latest_rotation' => $observations_number_in_latest_rotation]);
    }else
       return view('home.index');
    }
}
