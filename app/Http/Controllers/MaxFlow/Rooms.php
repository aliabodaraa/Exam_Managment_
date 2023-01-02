<?php

namespace App\Http\Controllers\MaxFlow;
use App\Models\Room;
use App\Http\Controllers\Controller;

class Rooms extends Controller
{
    private array $rooms_ids;
    private int $length;
    
    public function __construct(){
        $rooms=Room::where('is_active',1)->get()->pluck('id')->toarray();
        $this->rooms_ids=$rooms;
        $this->length=count($rooms);
    }

    public function getLength(){
        return $this->length;
    }

    public function getRooms(){
        return $this->rooms_ids;
    }
}
