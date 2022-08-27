<?php

namespace App\Http\Controllers;
use App\Models\room;
use Illuminate\Http\Request;

class roomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = room::orderBy('room_name')->get();
        return view('rooms.index', compact('rooms'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rooms.create');
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
            'room_name' => 'required|min:1|max:20|unique:rooms,room_name',
            'capacity' => 'required|min:1|max:1000',
        ],[
            'room_name.unique'=>'the name of room already exist'
        ]);
        room::create(
            [
                'room_name'=> $request->room_name,
                'capacity'=> $request->capacity,
                'location'=> $request->location,
                'notes'=> $request->notes,
            ]
        );
        return redirect()->route('rooms.index')
            ->withSuccess(__('room created successfully.'));
    }

    public function show(Room $room)
    {
        return view('rooms.show',compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        return view('rooms.edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request,[
            'room_name' => 'required|min:1|max:20',
            'capacity' => 'required|min:1|max:1000',
        ],[
            'room_name.exists'=>'the name of room does not exist'
        ]);
        $room->update($request->all());
        return redirect()->route('rooms.index')
            ->withSuccess(__('room updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->back()
            ->with('room-delete','room deleted successfully.');
    }
}
