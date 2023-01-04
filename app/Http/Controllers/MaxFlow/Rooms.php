<?php

namespace App\Http\Controllers\MaxFlow;
use App\Models\Room;
use App\Models\Rotation;
use App\Http\Controllers\Controller;

class Rooms extends Controller
{
    private Rotation $rotation;
    private array $rooms_ids;
    private int $length;
    
    public function __construct($rotation){
        $this->rotation=$rotation;
        //$rooms=Room::where('is_active',1)->get()->pluck('id')->toarray();
        $rooms=array_merge(array_unique($this->rotation->distributionRoom()->toBase()->pluck('id')->toarray()));//array_merge to keep the keys ordered
        //dd($rooms);
        $this->rooms_ids=$rooms;
        $this->length=count($rooms);
        //dd($this);
    }

    public function getLength(){
        return $this->length;
    }

    public function getRooms(){
        return $this->rooms_ids;
    }
}
