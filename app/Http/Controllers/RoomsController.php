<?php

namespace App\Http\Controllers;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Rooms.create');
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
            'room_name' => 'required|min:1|max:5|unique:rooms,room_name',
            'capacity' => 'required|min:1|max:1000',
        ],[
            'room_name.unique'=>'the name of room already exist'
        ]);
        Room::create(
            [
                'room_name'=> $request->room_name,
                'capacity'=> $request->capacity,
            ]
        );
        return redirect()->route('rooms.index')
            ->withSuccess(__('Room created successfully.'));
    }
//     function create(Request $request){
//         $rules=[
//            "name"=>"required|min:4",
//            "email"=>"required|email|unique:users,email",
//            "password"=>"required|min:5|max:30",
//            "confirmPassword"=>"required|same:password|min:5|max:30",
//        ];
//        $this->validate($request,$rules);
//        //dd($validate);
//                $create=User::create([
//               'name'=> $request->name,
//               'email'=> $request->email,
//               'password' => Hash::make($request['password']),
//               'confirmPassword' => Hash::make($request->get('password'))
//            ]);
//           //  dd($create);
//                if($create)
//                    return redirect()->route('user.home')->with("success","User succussfully Creates.");
//                else
//                    return redirect()->back()->with("fail","Try to Create this User Again.");

//   }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $Room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $Room)
    {
        return view('Rooms.show',compact('Room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $Room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $Room)
    {
        return view('Rooms.edit', ['Room' => $Room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $Room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $Room)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $Room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $Room)
    {
        $Room->delete();

        return redirect()->route('Rooms.index')
            ->with('user-delete','Room deleted successfully.');
    }
}
