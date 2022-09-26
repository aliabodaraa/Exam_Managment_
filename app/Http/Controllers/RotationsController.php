<?php

namespace App\Http\Controllers;
use App\Models\Rotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class rotationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$has_program=User::with('rooms','rotations')->get();
        //dd($has_program);
        $rotations = Rotation::orderBy('name')->get();
        return view('rotations.index', compact('rotations'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {//dd((int)date("Y"));
        return view('rotations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => [
                'required', 
                Rule::unique('rotations')//verify that the name with year don't repated (both are unique)
                       ->where('year', $request->year)
            ],
            //'year' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ],[
            'name.unique'=>'اسم الدورة موجود في السنة المحددة'
        ]);
        Rotation::create(
            [
                'name'=> $request->name,
                'year'=> (int)date("Y"),
                'start_date'=> $request->start_date,
                'end_date'=> $request->end_date,
            ]
        );
        return redirect()->route('rotations.index')
            ->withSuccess(__('rotation created successfully.'));
    }

    public function show(Rotation $rotation)
    {
        return view('rotations.show',compact('rotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function edit(Rotation $rotation)
    {
        return view('rotations.edit', ['rotation' => $rotation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rotation $rotation)
    {
        $this->validate($request,[
            'name' => [
                'required', 
                Rule::unique("rotations")->where(function ($query) use ($rotation) {
                        return $query->where(
                            [
                                ["year", "=", $rotation->year]
                            ]
                        );
                    })->ignore($rotation->id)//verify that the name with year don't repated (both are unique)(unique for escape comparing this routation)
            ],
            'year' => [
                'required', 
                Rule::unique("rotations")->where(function ($query) use ($rotation) {
                    return $query->where(
                        [
                            ["name", "=", $rotation->name]
                        ]
                    );
                })->ignore($rotation->id)//verify that the name with year don't repated (both are unique)(unique for escape comparing this routation)
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ],[
            'name.unique'=>'هذه السنة موجوده تتضمن الدورة المحددة',
            'year.unique'=>'هذه الدوره موجوده في السنة المحددة'
        ]);
        $rotation->update($request->all());
        return redirect()->route('rotations.index')
            ->withSuccess(__('rotation updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rotation  $rotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rotation $rotation)
    {
        $rotation->delete();

        return redirect()->back()
            ->with('rotations-delete','rotation deleted successfully.');
    }
}
