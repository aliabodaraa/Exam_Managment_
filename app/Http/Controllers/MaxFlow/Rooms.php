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
        $rooms=array_merge(array_unique($this->rotation->distributionRoom()->orderBy('id')->toBase()->pluck('id')->toarray()));//array_merge to keep the keys ordered
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
