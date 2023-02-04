<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Course;
use App\Models\Rotation;
use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ObservationsExport implements FromCollection,WithHeadings,WithBackgroundColor,WithStyles,ShouldAutoSize
{
    private Rotation $rotation;
    public function __construct(Rotation $rotation)
    {
        $this->rotation=$rotation;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {//$this->rotation->select like Rotation::select
        $all_observations_ids = $this->rotation->where('id','=',$this->rotation->id)
        ->select("user_id","roleIn","date","time","students_number","duration","course_rotation.rotation_id","course_rotation.course_id","num_student_in_room","course_room_rotation.room_id")
        ->join('course_rotation','rotations.id','=','course_rotation.rotation_id')
        ->join("course_room_rotation",function($join){
            $join->on("course_room_rotation.rotation_id","=","course_rotation.rotation_id")
                 ->on("course_room_rotation.course_id","=","course_rotation.course_id");})
        ->join("course_room_rotation_user",function($join){
            $join->on("course_room_rotation_user.rotation_id","=","course_room_rotation.rotation_id")
                 ->on("course_room_rotation_user.course_id","=","course_room_rotation.course_id")
                 ->on("course_room_rotation_user.room_id","=","course_room_rotation.room_id");})
        ->orderBy('course_rotation.date','ASC')
        ->orderBy('course_rotation.time','ASC')
        ->orderBy('course_rotation.course_id','ASC')
        ->orderBy('course_room_rotation.room_id','ASC')
        ->orderBy('course_room_rotation_user.roleIn','DESC')->get();
        // dd($all_observations_ids);
        $observations_names=[];
        foreach ($all_observations_ids as $index => $row) {
            $rotation_name=Rotation::where('id',$this->rotation->id)->toBase()->first()->name;
            $course_name=Course::where('id',$row['course_id'])->toBase()->first()->course_name;
            $room_name=Room::where('id',$row['room_id'])->toBase()->first()->room_name;
            $user_name=User::where('id',$row['user_id'])->toBase()->first()->username;
            if($row['roleIn']=="RoomHead")
                $user_role="رئيس قاعة";
            elseif($row['roleIn']=="Secertary")
                $user_role="أمين سر";
            elseif($row['roleIn']=="Observer")
                $user_role="مراقب";
            $date=$row['date'];
            $time=$row['time'];
            $duration=$row['duration'];
            $students_number=$row['students_number'];
            $num_student_in_room=$row['num_student_in_room'];
            $observations_names[$index]=[$rotation_name,$date,$time,$duration,$course_name,$students_number,$room_name,$num_student_in_room,$user_name,$user_role];
        }
        return collect($observations_names);
    }
    public function backgroundColor()
    {
        // Return RGB color code.
        return '999999';
    
        // Return a Color instance. The fill type will automatically be set to "solid"
        //return new Color(Color::COLOR_BLUE);
    
        // Or return the styles array
        return [
             'fillType'   => Fill::FILL_GRADIENT_LINEAR,
             //'startColor' => ['argb' => Color::COLOR_BLUE],
        ];
    }
    // public function columnWidths(): array
    // {
    //     return [
    //         'A' => 55,
    //         'B' => 45,          
    //         'C' => 55,
    //         'D' => 45,  
    //         'E' => 55,
    //         'F' => 45,
    //         'G' => 55,
    //         'H' => 45,  
    //         'I' => 55,
    //         'J' => 45,   
    //     ];
    // }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]],
        ];
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["الدورة الفصلية","التاريخ","الوقت","المدة","اسم المقرر","عدد المتقدمين للمقرر","اسم القاعة","عدد الطلاب بالقاعة","اسم الشخص","دور الشخص"];
    }
}
