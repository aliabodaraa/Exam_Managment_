<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rotation;
use App\Models\Course;
use App\Models\Room;
use App\Http\Controllers\MaxMinRoomsCapacity\Stock;
class CourseRotationController extends Controller
{
    public function get_room_for_course(Rotation $rotation, Course $course, Room $specific_room){
        //dd(Stock::getUsersInSpecificRotationCourseRoom($rotation,$course,$specific_room));
        //calculate rooms_this_course_rotation
        $rooms_this_course=Stock::getRoomsForSpecificCourse($rotation, $course);
        //calculate date & time & duration _ for specific course
        list($date, $time, $duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);

        //calc Joining rooms and disabled rooms and courses_common_with_time
        list($disabled_rooms, $joining_rooms, $courses_common_with_time)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course);
        
        //calc accual_common_rooms_for_specific_course
        $accual_common_rooms_for_specific_course=Stock::getAccualCommonRoomsForSpecificRotationCourse($rotation, $course);
        //dd($joining_rooms);
        //calc number students in this course
        list($entered_students_number, $occupied_number_of_students_in_this_course)=Stock::getOccupiedNumberOfStudentsInThisCourse($rotation, $course);

        //calc accual_common_rooms_for_specific_course
        list($accual_common_rooms_for_specific_course,$common_rooms_ids)=Stock::getAccualCommonRoomsForSpecificRotationCourse($rotation, $course);
        list($room_heads_in_this_rotation_course_room, $secertaries_in_this_rotation_course_room, $observers_in_this_rotation_course_room)=Stock::getUsersInSpecificRotationCourseRoom($rotation,$course,$specific_room);
//dd($room_heads_in_this_rotation_course_room,$secertaries_in_this_rotation_course_room, $observers_in_this_rotation_course_room);
        $occupied_number_of_students_in_this_course_in_this_room=Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course, $specific_room);

        $all_disabled_users_in_joining_room=Stock::getUsersInJoiningRoomsForDisabledThemWithRotationCourse($rotation,$course);
        //if(in_array($specific_room->id,$joining_rooms) || (in_array($specific_room->id,$rooms_this_course) && in_array($specific_room->id,$disabled_rooms))){
            list($room_heads_in_current_joining_in_this_rotation_course_room, $secertaries_in_current_joining_in_this_rotation_course_room, $observers_in_current_joining_in_this_rotation_course_room) = Stock::getUsersInSpecificJoiningRoomForRotationCourseRoom($rotation,$course,$specific_room);
            $pure_disabled_users_for_joining_room=array_diff(array_unique($all_disabled_users_in_joining_room),array_merge($room_heads_in_current_joining_in_this_rotation_course_room, $secertaries_in_current_joining_in_this_rotation_course_room, $observers_in_current_joining_in_this_rotation_course_room));
                //dd($user_in_current_joining_room);
        //}
        //dd($accual_common_rooms_for_specific_course);
        //dd($joining_rooms);
            return view('Rotations.ExamProgram.courses.rooms.edit_course_room',
            compact('rotation','course','specific_room','date','time','duration',
            'courses_common_with_time','common_rooms_ids',
            'accual_common_rooms_for_specific_course','entered_students_number', 
            'occupied_number_of_students_in_this_course',
            'occupied_number_of_students_in_this_course_in_this_room','joining_rooms','all_disabled_users_in_joining_room',
            'room_heads_in_this_rotation_course_room', 'secertaries_in_this_rotation_course_room',
            'observers_in_this_rotation_course_room','room_heads_in_current_joining_in_this_rotation_course_room',
            'secertaries_in_current_joining_in_this_rotation_course_room','observers_in_current_joining_in_this_rotation_course_room',
            'pure_disabled_users_for_joining_room'));
    }

    public function customize_room_for_course(Request $request, Rotation $rotation, Course $course, Room $specific_room){//dd($request);
        //dd(count($specific_room->users->toArray()));
        //calculate rooms_this_course_rotation
        $rooms_this_course=Stock::getRoomsForSpecificCourse($rotation, $course);            //dd($request);
         //calc Joining rooms and disabled rooms and courses_common_with_time
        list($disabled_rooms, $joining_rooms, $courses_common_with_time)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course);
        //calculate rooms_this_course_rotation
        
        //verify members passed
        if($request->get('roomheads') == null && $request->get('secertaries') == null && $request->get('observers') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد رئيس قاعة واحد وأمين سر واحد ومراقب واحد على الأقل");
        elseif($request->get('secertaries') == null && $request->get('observers') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد أمين سر واحد ومراقب واحد على الأقل");
        elseif($request->get('roomheads') == null && $request->get('secertaries') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد رئيس قاعة واحد وأمين سر واحد على الأقل");
        elseif($request->get('roomheads') == null && $request->get('observers') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد رئيس قاعة واحد ومراقب واحد على الأقل");
        elseif($request->get('roomheads') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد رئيس قاعة واحد على الأقل");
        elseif($request->get('secertaries') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد أمين سر واحد على الأقل");
        elseif($request->get('observers') == null)
            return redirect()->back()->with('select-members',"عذرا يجب أن تحدد مراقب واحد على الأقل");

        if(!in_array($specific_room->id,$rooms_this_course) && !in_array($specific_room->id, $joining_rooms)){//New Room
            //Done
            $course->distributionRoom()->attach($specific_room->id, ['rotation_id'=>$rotation->id,'num_student_in_room'=> $request['num_student_in_room']]);
            $specific_room->users()->attach($request->get('roomheads'), ['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=> 'RoomHead']);
            $specific_room->users()->attach($request->get('secertaries'), ['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=> 'Secertary']);    
            $specific_room->users()->attach($request->get('observers'), ['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=> 'Observer']);
        }elseif(in_array($specific_room->id, $disabled_rooms) && in_array($specific_room->id, $rooms_this_course) ){//Manage Room
            foreach ($courses_common_with_time as $course_common_with_time) {
                if($course_common_with_time->id == $course->id)
                    $course->distributionRoom()->updateExistingPivot($specific_room->id, ['rotation_id'=>$rotation->id,'num_student_in_room'=> $request['num_student_in_room']]);
                else
                    $course_common_with_time->distributionRoom()->updateExistingPivot($specific_room->id, ['rotation_id'=>$rotation->id,'num_student_in_room'=> Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course_common_with_time, $specific_room) ]);

                $specific_room->users()->wherePivot('rotation_id',$rotation->id)->wherePivot('course_id',$course_common_with_time->id)->detach();
                $specific_room->users()->attach($request->get('roomheads'), ['rotation_id'=>$rotation->id,'course_id'=>$course_common_with_time->id,'roleIn'=> 'RoomHead']);
                $specific_room->users()->attach($request->get('secertaries'), ['rotation_id'=>$rotation->id,'course_id'=>$course_common_with_time->id,'roleIn'=> 'Secertary']);    
                $specific_room->users()->attach($request->get('observers'), ['rotation_id'=>$rotation->id,'course_id'=>$course_common_with_time->id,'roleIn'=> 'Observer']);
            }
        }elseif(in_array($specific_room->id, $joining_rooms) ){//Joining Room
            //Done
            //list($room_heads_in_current_joining_in_this_rotation_course_room, $secertaries_in_current_joining_in_this_rotation_course_room, $observers_in_current_joining_in_this_rotation_course_room) = Stock::getUsersInSpecificJoiningRoomForRotationCourseRoom($rotation,$course,$specific_room);
            foreach ($courses_common_with_time as $course_common_with_time) {
                if($course_common_with_time->id == $course->id){
                    $course_common_with_time->distributionRoom()->attach($specific_room->id, ['rotation_id'=>$rotation->id,'num_student_in_room'=> $request['num_student_in_room']]);
                }else{
                    $course_common_with_time->distributionRoom()->updateExistingPivot($specific_room->id, ['rotation_id'=>$rotation->id,'num_student_in_room'=> Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course_common_with_time, $specific_room)]);
                    $specific_room->users()->wherePivot('rotation_id',$rotation->id)->wherePivot('course_id',$course_common_with_time->id)->detach();
                }
                $specific_room->users()->attach($request->get('roomheads'), ['rotation_id'=>$rotation->id,'course_id'=>$course_common_with_time->id,'roleIn'=> 'RoomHead']);
                $specific_room->users()->attach($request->get('secertaries'), ['rotation_id'=>$rotation->id,'course_id'=>$course_common_with_time->id,'roleIn'=> 'Secertary']);    
                $specific_room->users()->attach($request->get('observers'), ['rotation_id'=>$rotation->id,'course_id'=>$course_common_with_time->id,'roleIn'=> 'Observer']);
            }
        }elseif(! in_array($specific_room->id, $disabled_rooms) && in_array($specific_room->id, $rooms_this_course) ){//SingleRoom
            //Done
            //dd($specific_room->courses()->allRelatedIds());
            $course->distributionRoom()->updateExistingPivot($specific_room->id, ['num_student_in_room'=> $request['num_student_in_room']]);
            $specific_room->users()->wherePivot('rotation_id',$rotation->id)->wherePivot('course_id',$course->id)->detach();
            $specific_room->users()->attach($request->get('roomheads'),['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=> 'RoomHead']);
            //$specific_room->users()->syncWithoutDetaching($request->get('roomheads'));
            $specific_room->users()->attach($request->get('secertaries'), ['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=> 'Secertary']);    
            //$specific_room->users()->syncWithoutDetaching($request->get('secertaries')); 
            $specific_room->users()->attach($request->get('observers'), ['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=> 'Observer']);
            //$specific_room->users()->syncWithoutDetaching($request->get('observers'));

        }


        return redirect("/rotations/$rotation->id/course/$course->id/edit");//->with('update-course-room','Room '.$specific_room->room_name.' in Course '.$course->course_name.' updated successfully')->with(['disabled_rooms'=>$disabled_rooms,'common_rooms'=>$common_rooms]);
    }

    public function show(Rotation $rotation, Course $course)
    {
        return view('Rotations.ExamProgram.courses.show',compact('course','rotation'));
    }

    public function edit(Rotation $rotation, Course $course)
    {
        //calculate rooms_this_course_rotation
        $rooms_this_course=Stock::getRoomsForSpecificCourse($rotation, $course);

        //calculate date & time & duration _ for specific course
        list($date, $time, $duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);

        //calc Joining rooms and disabled rooms and courses_common_with_time
        list($disabled_rooms, $joining_rooms, $courses_common_with_time)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course);
        
        //calc accual_common_rooms_for_specific_course
        list($accual_common_rooms_for_specific_course,$common_rooms_ids)=Stock::getAccualCommonRoomsForSpecificRotationCourse($rotation, $course);
    //dd($accual_common_rooms_for_specific_course);
        //dd($accual_common_rooms_for_specific_course);
        $disabled_common_rooms_send=[];
                if(count($accual_common_rooms_for_specific_course)){//modify disabled course when is there accual common course
                    $disabled_rooms_accual=[];
                    foreach ($disabled_rooms as $room) {
                        if(!in_array($room, $rooms_this_course))
                            array_push($disabled_rooms_accual,$room);
                        else
                            array_push($disabled_common_rooms_send,$room);
                    }
                    $disabled_rooms=array_unique($disabled_rooms_accual);
                }

        //calc number students in this course
        list($entered_students_number, $occupied_number_of_students_in_this_course)=Stock::getOccupiedNumberOfStudentsInThisCourse($rotation, $course);
            //dd($joining_rooms);
        return view('Rotations.ExamProgram.courses.edit', 
        compact('rotation','course','rooms_this_course','disabled_rooms','joining_rooms','courses_common_with_time',
        'common_rooms_ids','disabled_common_rooms_send','occupied_number_of_students_in_this_course',
        'entered_students_number','date','time','duration'));
    }
    public function update(Request $request, Rotation $rotation, Course $course)
    {
        $course->update($request->only('course_name','studing_year','semester','faculty_id'));

        //copy from edit
        //calculate rooms_this_course_rotation
        $rooms_this_course=Stock::getRoomsForSpecificCourse($rotation, $course);

        //calc Joining rooms and disabled rooms and courses_common_with_time
        list($disabled_rooms,,)=Stock::getDisabledAndJoiningRoomsAndCommonCoursesWithTime($rotation, $course);
        //calc accual_common_rooms_for_specific_course
        
        list($accual_common_rooms_for_specific_course,$common_rooms_ids)=Stock::getAccualCommonRoomsForSpecificRotationCourse($rotation, $course);
        $disabled_common_rooms_send=[];
                if(count($accual_common_rooms_for_specific_course)){//modify disabled course when is there accual common course
                    $disabled_rooms_accual=[];
                    foreach ($disabled_rooms as $room) {
                        if(!in_array($room, $rooms_this_course))
                            array_push($disabled_rooms_accual,$room);
                        else
                            array_push($disabled_common_rooms_send,$room);
                    }
                    $disabled_rooms=array_unique($disabled_rooms_accual);
                }
        //calc number students in this course
        list($entered_students_number, )=Stock::getOccupiedNumberOfStudentsInThisCourse($rotation, $course);
        //copy from edit

        $rooms_filtered=[];
        if($request->rooms)
        foreach ($request->rooms as $room_id_req) 
            if(!in_array($room_id_req, $disabled_common_rooms_send))
                array_push($rooms_filtered, (int)$room_id_req);
            // elseif(in_array($room_id_req, $disabled_common_rooms_send))
            //     return redirect()->back()->with('disabled_rooms',"!! ");  
        if($request->rooms){
                $num_students_taken_in_requested_rooms=[];//register each room in request->rooms with number of student in each one before detach them
                foreach ($request->rooms as $room) {
                    $num_students_taken_in_requested_rooms[$room] = Stock::getOccupiedNumberOfStudentsInThisCourseInSpecificRoom($rotation, $course, Room::find($room));//register each room in request->rooms with number of student in each one before detach them
                    $members_taken_in_requested_rooms[$room]=Stock::getUsersInSpecificRotationCourseRoom($rotation,$course,Room::find($room));//register members in each room in request->rooms before detach them
                }

                 list($entered_students_number,)=Stock::getOccupiedNumberOfStudentsInThisCourse($rotation, $course);
                 list(,,$duration)=Stock::getDateTimeDuration_ForThisCourse($rotation, $course);
                 if(true){
                    $rotation->coursesProgram()->updateExistingPivot($course->id,['date'=> $request->date,'time'=>$request->time,'students_number'=> $entered_students_number,'duration'=>$request->duration]);
                    $rotation->distributionCourse()->detach($course->id);//delete all rooms in this course thats causes delete all users dynamically due to exist the foregin key between both tables
                     foreach ($request->rooms as $roomD) {
                        $current_room=Room::find($roomD);
                        $course->distributionRoom()->attach($roomD, ['rotation_id'=>$rotation->id,'num_student_in_room'=> $num_students_taken_in_requested_rooms[$roomD]]);
                        $current_room->users()->attach($members_taken_in_requested_rooms[$roomD][0],['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=>'RoomHead']);
                        $current_room->users()->attach($members_taken_in_requested_rooms[$roomD][1],['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=>'Secertary']);
                        $current_room->users()->attach($members_taken_in_requested_rooms[$roomD][2],['rotation_id'=>$rotation->id,'course_id'=>$course->id,'roleIn'=>'Observer']);
                        }
                     return redirect()->route("rotations.program.show",[$rotation->id])->with('user-update',' تم تعديل مقرر'.$course->course_name.' بنجاح ');
                 }else
                     return redirect()->back()->with('detemine-rooms',"The rooms that you have already selected have not any user , Please select One user at least in any room");
         }else{
            return redirect()->back()->with('detemine-rooms',"عذرا يجب أن تحدد مادة على الأقل");
        }
    }

}
