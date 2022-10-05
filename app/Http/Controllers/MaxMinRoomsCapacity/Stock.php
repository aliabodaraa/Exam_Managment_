<?php

namespace App\Http\Controllers\MaxMinRoomsCapacity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class Stock extends Controller
{
    public static function getMaxDistribution(){
        $max_distribution_count=0;
        foreach (Room::all() as $room) {
            if($room->is_active){
                if($room->extra_capacity)
                    $max_distribution_count+=($room->capacity+$room->extra_capacity);
                else
                    $max_distribution_count+=$room->capacity;
            }
        }
        return $max_distribution_count;
    }
    public static function getMinDistribution(){
        $min_distribution_count=0;
        foreach (Room::all() as $room) {
            if($room->is_active){
                $min_distribution_count+=$room->capacity;
            }
        }
        return $min_distribution_count;
    }
}
