<?php

namespace App\Http\Controllers\MaxFlow;
use App\Models\Rotation;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MaxFlow\EnumPersonType;

class Members extends Controller
{
    private EnumPersonType $type;
    private Rotation $rotation;
    private array $members_ids;
    private int $length;
    
    public function __construct(EnumPersonType $type,Rotation $rotation){
        $this->type=$type;
        $this->rotation=$rotation;
        $room_heads=$this->rotation->initial_members()->wherePivot('options','{"1":"on"}')->orWherePivot('options','{"1":"on","2":"on"}')->toBase()->get()->pluck('id')->toarray();
        //dd(User::toBase()->first()); //toBase returns raw data as you use query
        $secertaries=$this->rotation->initial_members()->wherePivot('options','{"2":"on"}')->orWherePivot('options','{"1":"on","2":"on"}')->toBase()->get()->pluck('id')->toarray();
        $observers=array_unique(array_merge(User::where('is_active',1)->where('temporary_role')->whereNotIn('id',$room_heads)->toBase()->get()->pluck('id')->toarray(),$secertaries));
        switch($this->type){
            case EnumPersonType::RoomHead:
                $members=$room_heads;
                break;
            case EnumPersonType::Secertary:
                $members=$secertaries;
                break;
            case EnumPersonType::Observer:
                $members=$observers;
                break;
            default:
                dd("ERROR");
        }
        $this->members_ids=$members;
        $this->length=count($members);
    }

    public function getLength(){
        return $this->length;
    }

    public function getMembers(){
        return $this->members_ids;
    }
    public function getNumOfObservationsForSpecificMember($member_id){
        $num_observation_for_passed_member_id=User::where('id',$member_id)->first()->number_of_observation;
        return $num_observation_for_passed_member_id;
    }
}
