<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Course;
use App\Models\Rotation;
use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    { 
                $all_observations_ids = Rotation::query()->where('id', '=', Rotation::latest()->first()->id)
                //->join('course_rotation','rotations.id','=','course_rotation.rotation_id')
                ->join('course_room_rotation_user','rotations.id','=','course_room_rotation_user.rotation_id')
                //->orderBy('course_rotation.date','ASC')->orderBy('course_rotation.time','ASC')
                ->orderBy('course_room_rotation_user.course_id','ASC')
                ->get('course_room_rotation_user.*');
                //dd($all_observations_ids);
                $observations_names=[];
                foreach ($all_observations_ids as $index => $row) {
                    $user_name=User::where('id',$row['user_id'])->toBase()->first()->username;
                    if($row['roleIn']=="RoomHead")
                        $user_role="رئيس قاعة";
                    elseif($row['roleIn']=="Sercertary")
                        $user_role="أمين سر";
                    elseif($row['roleIn']=="Observer")
                        $user_role="مراقب";
                    $room_name=Room::where('id',$row['room_id'])->toBase()->first()->room_name;
                    $course_name=Course::where('id',$row['course_id'])->toBase()->first()->course_name;
                    $rotation_name=Rotation::where('id',$row['rotation_id'])->toBase()->first()->name;
                    $observations_names[$index]=[$rotation_name,$course_name,$room_name,$user_name,$user_role];
                }
        return collect($observations_names);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["الدورة الفصلية","اسم المقرر","اسم القاعة","اسم الشخص","دور الشخص"];
    }
}
