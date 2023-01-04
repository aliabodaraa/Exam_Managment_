<?php

namespace App\Http\Controllers\MaxFlow;

use App\Http\Controllers\Controller;
use App\Models\Rotation;
use App\Http\Controllers\MaxFlow\EnumPersonType;
use App\Http\Controllers\MaxFlow\Members;
use App\Http\Controllers\MaxFlow\Courses;
use App\Http\Controllers\MaxFlow\MaxFlow;
use App\Http\Controllers\MaxFlow\Dfs;
use App\Models\Course;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Carbon\Carbon;
class Graph extends Controller
{
    private Members $members;
    private Courses $courses;
    private Rooms $rooms;
    private Rotation $rotation;
    private array $arr_graph=[];
    private int $length_graph;
    private array $arr_users_objetions_orderd;
    private array $arr_keys_users_objections_orderd;
    private array $arr_courses_num_objections_orderd;
    private array $arr_same_time_courses;
    private int $count_arr_same_time_courses;
    private array $arr_courses_with_count_of_rooms;
    private array $arr_courses_idx_date_time;
    private EnumPersonType $type;
    
    public function __construct(EnumPersonType $type, Rotation $rotation, array $paths_info=array()){
        $this->type = $type;
        $this->rotation=$rotation;
        $this->members=new Members($type,$this->rotation);
        $this->arr_users_objetions_orderd=$this->getUsersWithObjectionsOnCourses();
        $this->arr_keys_users_objections_orderd=array_keys($this->arr_users_objetions_orderd);
        $this->courses=new Courses($this->rotation);
        $this->arr_courses_num_objections_orderd=array_keys($this->getCourseWithNumOfObservation());
        $this->arr_courses_idx_date_time=$this->coursesWithArrDateAndTime();
        // dd($this->getCourseWithNumOfObservation(),$this->getCoursesWithCountOfRooms(),$this->courses);
        $this->rooms=new Rooms($this->rotation);
        $this->arr_same_time_courses=$this->coursesInSameTimes()[0];
        $this->count_arr_same_time_courses=$this->coursesInSameTimes()[1];
        $this->arr_courses_with_count_of_rooms=$this->getCoursesWithCountOfRooms();
        $this->buildGraph($paths_info);
    }

    public function buildGraph(array $paths_info=array()){
        list($same_times,$num_distict_times)=$this->coursesInSameTimes();
        $this->length_graph=$this->members->getLength()+$num_distict_times+$this->courses->getLength()+$this->rooms->getLength()+2;
        $this->initializeGraphWithZeroValues();//initalize the graph with zero values
        $this->linkSourceWithUsers($num_distict_times);//link source node with users via the observations of them
        $this->setUsersWithSameTimeNodes($same_times);//link users node with courses that have not objections of them in latest rotation

        if(isset($paths_info["users_observations"]) && count($paths_info)>0)
            if($this->type->name == "Secertary" || $this->type->name == "Observer")
                $this->cutEdgesFromUsersToSameTimeNodes($paths_info,$same_times);

        $this->setSameTimeNodesToCourses($same_times,$num_distict_times);//link each sameTimeNode with the courses that belong to it
        $this->setCoursesRooms($num_distict_times);//link each course with the rooms that belong to it
        $this->dfsOnSameTimeNodes();//remove link to the common rooms that collabrate between more than course in the same time
        $this->setSameTimeNodesToCoursesAfterDfs($same_times,$num_distict_times);//------------------------Long Term-----------------------------
        $this->linkRoomsWithSink($num_distict_times);//link rooms nodes with the sink node
        //dd("::::",$this->arr_courses_num_objections_orderd[148-144-1]);//->rooms->getRooms()[236-(144+82)]);//[147-144]);
        //dd($this->arr_graph[148],'users',$this->arr_users_objetions_orderd,'courses',$this->arr_courses_num_objections_orderd,'rooms',$this->rooms->getRooms(),'sameTime',$this->arr_same_time_courses,'countSameTime',$this->count_arr_same_time_courses);
        // dump( //$this->arr_graph,
        //     //$this->arr_users_objetions_orderd,
        //     array_keys($this->arr_users_objetions_orderd),
        //     //$this->arr_courses_num_objections_orderd,
        //     //$this->rooms->getRooms(),
        //     //$this->arr_same_time_courses,
        //     //$this->getCourseWithNumOfObservation(),
        //     //$this->getCoursesRooms()
        // );

    }
    //0
    public function cutEdgesFromUsersToSameTimeNodes(array $paths_info,array $same_times){
        $users_pre=array_keys($paths_info['users_observations']);
        foreach ($this->arr_keys_users_objections_orderd as $user_id) {
            if(!in_array($user_id,$users_pre)) continue;
            $key_user=$this->getKeyFromArray($user_id,$this->arr_keys_users_objections_orderd);
            foreach ($paths_info['users_observations'] as $user_observations)
                foreach ($user_observations as $observation) {
                    $key_course=$this->getKeyFromArray($observation['course'],$this->arr_courses_num_objections_orderd);
                    $this->arr_graph[$key_user+1][$this->members->getLength()+$same_times[$key_course]+1]=0;
                }
        }
    }

    //1
    public function getUsersWithObjectionsOnCourses(){//users with objections on courses in latest rotation [as edges]
        $users_courses_objections=[];
        $user_ids_objected=$this->rotation->usersObjection()->get()->pluck('id')->toarray();
        foreach($this->members->getMembers() as $member_id){
            $member=User::where('id',$member_id)->first();
            $courses_user=[];
            if(in_array($member_id,$user_ids_objected))
                if(in_array($member_id,$this->members->getMembers())){
                    $courses_user=[];
                    foreach ($member->coursesObjection()->wherePivot('rotation_id',$this->rotation->id)->toBase()->get() as $course)
                        array_push($courses_user,$course->id);

                    $users_courses_objections[$member_id]=$courses_user;
                }
            $users_courses_objections[$member_id]=$courses_user;
        }
        uasort($users_courses_objections,fn($a,$b)=>count($a)<count($b));//sort via the user that have max objections
        return $users_courses_objections;
    }
    //2
    public function getCourseWithNumOfObservation(){//get all course with num of objections ordered min
        $arr_courses_num_objections_orderd=[];
        foreach ($this->courses->getCourses() as $course_id){
            $num=0;
            foreach ($this->arr_users_objetions_orderd as $arr_courses_ids) {
                foreach ($arr_courses_ids as $ele_course_id)
                    if($course_id==$ele_course_id)
                        $num++;
            }
            $arr_courses_num_objections_orderd[$course_id]=$num;
        }
        uasort($arr_courses_num_objections_orderd,fn($a,$b)=>$a<$b);//sort via the course that have max objections
        return $arr_courses_num_objections_orderd;
    }

    public function initializeGraphWithZeroValues(){//initalize the graph with zero values
        for ($i=0; $i < $this->length_graph; $i++)
            for ($j=0; $j < $this->length_graph; $j++)
                $this->arr_graph[$i][$j]=0;
    }

    public function linkSourceWithUsers(){//link source node with users via the observations of them
        for ($i=0; $i < $this->members->getLength(); $i++) {
            $user_id=$this->arr_keys_users_objections_orderd[$i];
            $this->arr_graph[0][$i+1]=$this->members->getNumOfObservationsForSpecificMember($user_id);
        }
    }

    public function setUsersWithSameTimeNodes(array $same_times){//link users node with courses that have not objections of them in latest rotation
        foreach ($this->arr_keys_users_objections_orderd as $user_id) {
            $key_user=$this->getKeyFromArray($user_id,$this->arr_keys_users_objections_orderd);
            foreach ($this->arr_courses_num_objections_orderd as $course_id) {
                $key_course=$this->getKeyFromArray($course_id,$this->arr_courses_num_objections_orderd);
                if(!in_array($course_id,$this->arr_users_objetions_orderd[$user_id]))
                    $this->arr_graph[$key_user+1][$this->members->getLength()+$same_times[$key_course]+1]=1;
            }
        }
    }
    public function coursesWithArrDateAndTime(){
        $arr_courses_idx_date_time=[];
        for ($i=0; $i < $this->courses->getLength() ; $i++) {
            $curr_course=Course::where('id',$this->arr_courses_num_objections_orderd[$i])->first();
            $arr_courses_idx_date_time[$i]['date']=$curr_course->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->date;
            $arr_courses_idx_date_time[$i]['time']=$curr_course->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->time;
            $arr_courses_idx_date_time[$i]['duration']=$curr_course->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->duration;
        }
        return $arr_courses_idx_date_time;
    }
    public function coursesInSameTimes(){
        $same_times[0]=$counter=0;
        for ($i=1; $i < $this->courses->getLength() ; $i++) {
            $curr_date=$this->arr_courses_idx_date_time[$i]['date'];
            $curr_time=$this->arr_courses_idx_date_time[$i]['time'];
            $curr_duration=$this->arr_courses_idx_date_time[$i]['duration'];

            $pre_date=$this->arr_courses_idx_date_time[$i-1]['date'];
            $pre_time=$this->arr_courses_idx_date_time[$i-1]['time'];
            

            if($pre_date==$curr_date && ( $pre_time>=$curr_time && $pre_time <= gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration))) || ( $pre_time<=$curr_time && $pre_time >= gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration)))){
                $same_times[$i]=$same_times[$i-1];
                continue;
            }
            $same_times[$i]=++$counter;
        }
        $num_distict_times=$same_times[count($same_times)-1]+1;//count(array_unique($same_times));

        return array($same_times,$num_distict_times);
    }

    public function setSameTimeNodesToCourses(){
        foreach ($this->arr_same_time_courses as $course_index => $same_time_index)
            $this->arr_graph[$this->members->getLength()+$same_time_index+1][$this->members->getLength()+$this->count_arr_same_time_courses+$course_index+1]=1;
    }

    public function setSameTimeNodesToCoursesAfterDfs(){
        foreach ($this->arr_same_time_courses as $course_index => $same_time_index)
            $this->arr_graph[$this->members->getLength()+$same_time_index+1][$this->members->getLength()+$this->count_arr_same_time_courses+$course_index+1]=$this->arr_courses_with_count_of_rooms[$this->arr_courses_num_objections_orderd[$course_index]];
    }

    public function setCoursesRooms(int $num_distict_times){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms_ids=$this->getCoursesRooms();
        foreach ($courses_rooms_ids as $course_id => $rooms_ids) {
            $key_course=$this->getKeyFromArray($course_id,$this->arr_courses_num_objections_orderd);
            foreach ($rooms_ids as $room_id) {
                $key_room=$this->getKeyFromArray($room_id,$this->rooms->getRooms());
                $this->arr_graph[$this->members->getLength()+$num_distict_times+$key_course+1][$this->members->getLength()+$num_distict_times+$this->courses->getLength()+$key_room+1]=1;
            }
        }
    }

    public function dfsOnSameTimeNodes(){//remove link to the common rooms that are common between more than course in the same time
        for ($i=0; $i < $this->count_arr_same_time_courses; $i++)
                $dfs=new Dfs($this->arr_graph,$this->members->getLength()+$i+1);
    }

    public function linkRoomsWithSink(int $num_distict_times){//link rooms nodes with the sink node
        for ($i=0; $i < $this->rooms->getLength(); $i++)
            $this->arr_graph[$this->members->getLength()+$num_distict_times+$this->courses->getLength()+$i+1][$this->length_graph-1]=PHP_INT_MAX;
    }

    public function getKeyFromArray(int $valueE,array $arr){//get the key corresponding with the id of the first type parameter in the second array parameter
        foreach ($arr as $key => $value)
            if($value === $valueE)
                return $key;
    }

    public function getCoursesRooms(){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms=[];
        foreach ($this->rotation->coursesProgram()->get() as $course) {
            $rooms_course=[];
            foreach ($course->distributionRoom()->wherePivot('rotation_id',$this->rotation->id)->get() as $room){
                // if($course->id ==87){
                //     dump("+++",$room->id,"+++");
                // }
                array_push($rooms_course,$room->id);
            }
                
                
            $courses_rooms[$course->id]=$rooms_course;
        }
        return $courses_rooms;
    }
    public function getCoursesWithCountOfRooms(){//courses with distributed rooms in latest rotation [as edges]
        $courses_with_count_rooms=[];
        foreach ($this->rotation->coursesProgram()->get() as $course)
            $courses_with_count_rooms[$course->id]=count($course->distributionRoom()->wherePivot('rotation_id',$this->rotation->id)->get());

        return $courses_with_count_rooms;
    }
    public function applyMaxFlowAlgorithm(){
        $obj_max = new MaxFlow($this->arr_graph,$this->length_graph);
        $paths=$obj_max->fordFulkerson($this->arr_graph, 0, $this->length_graph-1);
        //dd($this->arr_graph,$paths,'sameTime',$this->arr_same_time_courses,'courses',$this->arr_courses_num_objections_orderd,'users',$this->arr_users_objetions_orderd);
       // dd("++++++++",$paths);
        $pathsInfo=$this->convertFordFulkersonPaths($paths);
        //dd($this->arr_graph,$paths,$pathsInfo);
        return array($paths,$pathsInfo);
    }
    
    public function convertFordFulkersonPaths(array $paths){//convert the indeces paths to real index corresponding to users ,courses ,rooms
            $pathsInfo=[];
            $pathsInfo['num_members']=$this->members->getLength();
            $count_arr_users_objections_orderd=count($this->arr_keys_users_objections_orderd);
            $count_arr_courses_num_objections_orderd=count($this->arr_courses_num_objections_orderd);
            //dump($paths);
            for ($i=1; $i <=$this->members->getLength(); $i++) {
                $observations_num=0;
                foreach ($paths as $path) {
                    
                    if($i == $path[0]){   //$path[2]==147 && 

                        //if($this->arr_courses_num_objections_orderd[$path[2]-$this->count_arr_same_time_courses-$count_arr_users_objections_orderd-1] ==87)
                         //dd($count_arr_courses_num_objections_orderd, ": ",$this->count_arr_same_time_courses,": ",$count_arr_users_objections_orderd );
                        $pathsInfo['users_observations'][$this->arr_keys_users_objections_orderd[$i-1]][]=[
                            'granted_observations_num'=>++$observations_num,
                            //'rotation' =>$this->rotation->id,
                            'actual_observations_num'=>User::where('id',$this->arr_keys_users_objections_orderd[$i-1])->first()->number_of_observation,
                            'course' =>$this->arr_courses_num_objections_orderd[$path[2]-$this->count_arr_same_time_courses-$this->members->getLength()-1],
                            'room' =>$this->rooms->getRooms()[$path[3]-$count_arr_courses_num_objections_orderd-$this->count_arr_same_time_courses-$count_arr_users_objections_orderd-1],
                            'date'=>Course::where('id',$this->arr_courses_num_objections_orderd[$path[2]-$this->count_arr_same_time_courses-$count_arr_users_objections_orderd-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->date,
                            'time'=>Course::where('id',$this->arr_courses_num_objections_orderd[$path[2]-$this->count_arr_same_time_courses-$count_arr_users_objections_orderd-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->time,
                            'duration'=>Course::where('id',$this->arr_courses_num_objections_orderd[$path[2]-$this->count_arr_same_time_courses-$count_arr_users_objections_orderd-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->duration,
                            'roleIn'=>$this->type->name
                        ];
                    }
                }
            }

           // dd($pathsInfo);
            return $pathsInfo;
    }
}