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

class ObservationsExport implements FromCollection,WithHeadings,WithStyles,ShouldAutoSize,WithBackgroundColor
{
    private Rotation $rotation;
    public function __construct(Rotation $rotation)
    {
        $this->rotation=$rotation;
    }
    // public function map($invoice): array
    // {
    //     // This example will return 3 rows.
    //     // First row will have 2 column, the next 2 will have 1 column
    //     return [
    //         [
    //             $invoice->invoice_number,
    //             Date::dateTimeToExcel($invoice->created_at),
    //         ],
    //         [
    //             $invoice->lines->first()->description,
    //         ],
    //         [
    //             $invoice->lines->last()->description,
    //         ]
    //     ];
    // }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {//$this->rotation->select like Rotation::select
        ini_set('max_execution_time', 360); //6 minutes
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
        //dump($all_observations_ids[0],$all_observations_ids[1],$all_observations_ids[2]);
        $custom_courses=[];
        foreach ($this->rotation->coursesProgram()->orderByPivot('course_rotation.date')->orderByPivot('course_rotation.time')->get() as $course) {
            $bool_headers=false;
                foreach ($course->rooms as $room) {
                    $roomHeads=[];
                    $secertaries=[];
                    $observers=[];
                    $num_student_in_room=0;
                    foreach ($all_observations_ids as $index => $row) {
                        if($course->id === $row['course_id'] && $room->id === $row['room_id']){
                            // if(!$bool_header){
                            //     $str_students_number="عدد المتقدمين للمقرر : ".$row['students_number'];
                            //     $time="الوقت :".$row['time'];
                            //     $date="التاريخ :".$row['date'];
                            //     $custom_courses[$course->id]["header".rand()]=[$str_students_number,$time,$course->course_name,$date];
                            //     $bool_header=true;
                            // }
                            if(!$bool_headers){
                                $str_students_number="عدد المتقدمين للمقرر : ".$row['students_number'];
                                $time="الوقت :".$row['time'];
                                $date="التاريخ :".$row['date'];
                                $str_course="المقرر : ".$course->course_name;
                                $str_duration="المدة : ".$row['duration'];
                                $custom_courses[$course->id]["headerA".rand()]=[$str_students_number,$time,$str_duration,$str_course,$date];
                                $custom_courses[$course->id]["headerB".rand()]=["عدد الطلاب بالقاعة","المراقبون","أمناء السر","رئيس القاعة","القاعة"];
                                $bool_headers=true;
                            }
                            $num_student_in_room=$row['num_student_in_room'];
                            $current_user_name=User::where('id',$row['user_id'])->first()->username;
                            if($row['roleIn']==="RoomHead")
                                array_push($roomHeads,$current_user_name);
                            elseif($row['roleIn']==="Secertary")
                                array_push($secertaries,$current_user_name);
                            else
                                array_push($observers,$current_user_name);
                        }
                    }
                    if($num_student_in_room){
                        $custom_courses[$course->id][$room->id]=['num_student_in_room'=>$num_student_in_room,'Observer'=>implode(" - ", $observers),'Secertary'=>implode(" - ", $secertaries),'roomHead'=>implode(" - ", $roomHeads),'room_name'=>$room->room_name];
                    }
                    
                }
        }
        //dd($custom_courses);
        return collect($custom_courses);
        // dd($custom_courses);
        // $observations_names=[];
        // foreach ($all_observations_ids as $index => $row) {
        //     $rotation_name=Rotation::where('id',$this->rotation->id)->toBase()->first()->name;
        //     $course_name=Course::where('id',$row['course_id'])->toBase()->first()->course_name;
        //     $room_name=Room::where('id',$row['room_id'])->toBase()->first()->room_name;
        //     $user_name=User::where('id',$row['user_id'])->toBase()->first()->username;
        //     if($row['roleIn']=="RoomHead")
        //         $user_role="رئيس قاعة";
        //     elseif($row['roleIn']=="Secertary")
        //         $user_role="أمين سر";
        //     elseif($row['roleIn']=="Observer")
        //         $user_role="مراقب";
        //     $date=$row['date'];
        //     $time=$row['time'];
        //     $duration=$row['duration'];
        //     $students_number=$row['students_number'];
        //     $num_student_in_room=$row['num_student_in_room'];
        //     $observations_names[$index]=[$rotation_name,$date,$time,$duration,$course_name,$students_number,$room_name,$num_student_in_room,$user_name,$user_role];
        // }
        // dd($observations_names[0],$observations_names[1],$observations_names[2]);
        // return collect($observations_names);
    }
    public function backgroundColor()
    {
        // Return RGB color code.
        return 'eeeeee';
    
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
            //'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'A'  => ['font' => ['size' => 14]],
            'B'  => ['font' => ['size' => 14]],
            'C'  => ['font' => ['size' => 14]],
            'D'  => ['font' => ['size' => 14]],
            'E'  => ['font' => ['size' => 14]],
        ];
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return  [
            // 1    => ["الدورة الفصلية","التاريخ","الوقت","المدة","اسم المقرر","عدد المتقدمين للمقرر","اسم القاعة","عدد الطلاب بالقاعة","اسم الشخص","دور الشخص"],
            //1 => ["عدد الطلاب بالقاعة","المراقبون","أمناء السر","رئيس القاعة","القاعة"],
        ];
    }
}
