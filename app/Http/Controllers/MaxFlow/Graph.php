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
    private array $arr_keys_courses_num_objections_orderd;
    private array $arr_same_time_courses;
    private int $count_arr_same_time_courses;
    private array $arr_courses_with_count_of_rooms;
    private array $arr_courses_idx_date_time;
    private EnumPersonType $type;
    
    public function __construct(EnumPersonType $type, Rotation $rotation, array $roomheads_paths=array(), array $secertaries_paths=array()){
        $this->type = $type;
        $this->rotation=$rotation;

        $this->members=new Members($type,$this->rotation);
        $this->arr_users_objetions_orderd=$this->getUsersWithObjectionsOnCourses();
        $this->arr_keys_users_objections_orderd=array_keys($this->arr_users_objetions_orderd);
        
        $this->courses=new Courses($this->rotation);
        $this->arr_keys_courses_num_objections_orderd=array_keys($this->getCourseWithNumOfObservation());//depend on $this->arr_users_objetions_orderd
        $this->arr_courses_idx_date_time=$this->coursesWithArrDateAndTime();//depend on $this->courses ordered via date and time
        [$this->arr_same_time_courses,$this->count_arr_same_time_courses]=$this->coursesInSameTimes();//depend on arr_courses_idx_date_time re-orederd to adapt with $this->arr_keys_courses_num_objections_orderd
        $this->arr_courses_with_count_of_rooms=$this->getCoursesWithCountOfRooms();//depend on sameTimes array and $this->arr_keys_courses_num_objections_orderd
        //dd($this->arr_same_time_courses,$this->count_arr_same_time_courses);
        // dd($this->getCourseWithNumOfObservation(),$this->getCoursesWithCountOfRooms(),$this->courses);
        $this->rooms=new Rooms($this->rotation);
        $this->buildGraph($roomheads_paths, $secertaries_paths);
         

        //  if($this->type->name == "Observer"){
        //     dump("Graph",$this->arr_graph);
        //     dump("users",$this->arr_keys_users_objections_orderd);
        //  }

        //  dump("Graph",$this->arr_graph);
        //  dump("users",$this->arr_keys_users_objections_orderd);

        // for($i=count($this->arr_keys_users_objections_orderd)+$this->count_arr_same_time_courses+1;$i<=count($this->arr_keys_users_objections_orderd)+count($this->arr_keys_courses_num_objections_orderd)+$this->count_arr_same_time_courses;$i++){
        //     for($j=count($this->arr_keys_users_objections_orderd)+count($this->arr_keys_courses_num_objections_orderd)+$this->count_arr_same_time_courses+1;$j<=count($this->arr_keys_users_objections_orderd)+count($this->arr_keys_courses_num_objections_orderd)+$this->count_arr_same_time_courses+$this->rooms->getLength();$j++){
        //         if($this->arr_graph[$i][$j]>0){
        //             ++$counter;
        //         }
        //     }
        //     dump($counter);
        // }
        // dd($counter);
    }

    public function buildGraph(array $roomheads_paths=array(), $secertaries_paths=array()){//dump(221);
        $this->length_graph=$this->members->getLength()+$this->count_arr_same_time_courses+$this->courses->getLength()+$this->rooms->getLength()+2;
        //dd($this->members->getLength(),$this->count_arr_same_time_courses,$this->courses->getLength(),$this->rooms->getLength());
        $this->initializeGraphWithZeroValues();//initalize the graph with zero values
        $this->linkSourceWithUsers();//link source node with users via the observations of them
        $this->setUsersWithSameTimeNodes();//link users node with courses that have not objections of them in latest rotation

        if(
            ($this->type->name == "Observer" || $this->type->name == "Secertary") && 
            isset($roomheads_paths)){
                //dump("1");
                $this->subtractUsersObservations($roomheads_paths);
                $this->cutEdgesFromUsersToSameTimeNodes($roomheads_paths);
                
            }

        if(
            $this->type->name == "Observer" && 
            isset($secertaries_paths)){
                //dump("2");
                $this->subtractUsersObservations($secertaries_paths);
                $this->cutEdgesFromUsersToSameTimeNodes($secertaries_paths);
                
            }
        //for DFS
        $this->setSameTimeNodesToCourses();//link each sameTimeNode with the courses that belong to it with `1` to be able to run dfs
        $this->setCoursesRooms();//link each course with the rooms that belong to it
        $this->dfsOnSameTimeNodes();//remove link to the common rooms that collabrate between more than course in the same time
        //for DFS
        $this->setSameTimeNodesToCoursesAfterDfs();//set each course with number of belonged rooms
        $this->linkRoomsWithSink();//link rooms nodes with the sink node
    }
    //0
    public function cutEdgesFromUsersToSameTimeNodes(array $paths_info_param){
            foreach ($paths_info_param['users_observations'] as $user_id=> $user_observations){
                if(in_array($user_id,$this->members->getMembers())){
                    $key_user=$this->getKeyFromArray($user_id,$this->arr_keys_users_objections_orderd);
                    foreach ($user_observations as $observation) {
                        
                        $key_course=$this->getKeyFromArray($observation['course'],$this->arr_keys_courses_num_objections_orderd);
                        // if($this->type->name=="Secertary" ){
                        //     dd("insideCutEdge",$this->arr_keys_users_objections_orderd,$user_id,$key_user,$user_observations,$key_course, $this->arr_same_time_courses[$key_course],$this->members->getLength()+$this->arr_same_time_courses[$key_course]);
                        // }
                        $this->arr_graph[$key_user+1][$this->members->getLength()+$this->arr_same_time_courses[$key_course]+1]=0;
                    }
                }
                
            }
            // foreach ($paths_info_param as $key => $path) {//dd("Ali",$paths_info_param,$path);
            //     if(in_array($path[0]-1,$this->members->getMembers()))
            //         $this->arr_graph[$path[0]][$path[1]]=0;
            // }
    }
    public function countPathsForSpesificUser(array $paths_info_param,$user_id){
        $count=0;
        foreach ($paths_info_param as $key => $path) {
            if($user_id==$path[0])
                $count++;
        }
        return $count;
    }
    public function subtractUsersObservations(array $paths_info_param){
        foreach ($paths_info_param['users_observations'] as $user_id=> $user_observations){
            if(in_array($user_id,$this->members->getMembers())){
                    $key_user=$this->getKeyFromArray($user_id,$this->arr_keys_users_objections_orderd);
                    $total_num_observations_for_current_user=$this->members->getNumOfObservationsForSpecificMember($user_id);
                    $pre_num_observations_for_current_user_in_previous_graph=count($user_observations);
                    $final_num_observations_for_current_user_after_abstract=$total_num_observations_for_current_user-$pre_num_observations_for_current_user_in_previous_graph;
                    $this->arr_graph[0][$key_user+1]=$final_num_observations_for_current_user_after_abstract;
                }
        }
        // foreach ($paths_info_param as $key => $path) {
        //     if(in_array($path[0]-1,$this->members->getMembers())){
        //         $total_num_observations_for_current_user=$this->members->getNumOfObservationsForSpecificMember($path[0]-1);
        //         $pre_num_observations_for_current_user_in_previous_graph=$this->countPathsForSpesificUser($paths_info_param,$path[0]);
        //         $final_num_observations_for_current_user_after_abstract=$total_num_observations_for_current_user-$pre_num_observations_for_current_user_in_previous_graph;
        //         $this->arr_graph[0][$path[0]]=$final_num_observations_for_current_user_after_abstract;
        //     }
        // }
    }
    //1
    public function getUsersWithObjectionsOnCourses(){//users with objections on courses in latest rotation [as edges]
        $users_courses_objections=[];
        $users_ids_objected=$this->rotation->usersObjection()->get()->pluck('id')->toarray();
        foreach($this->members->getMembers() as $member_id){
            $member=User::where('id',$member_id)->first();
            $courses_user_objected=[];
            if(in_array($member_id,$users_ids_objected))
                if(in_array($member_id,$this->members->getMembers())){
                    $courses_user_objected=[];
                    foreach ($member->coursesObjection()->wherePivot('rotation_id',$this->rotation->id)->toBase()->get() as $course)
                        array_push($courses_user_objected,$course->id);

                    $users_courses_objections[$member_id]=$courses_user_objected;
                }
            $users_courses_objections[$member_id]=$courses_user_objected;
        }
        uasort($users_courses_objections,fn($a,$b)=>count($a)<count($b));//sort via the user that have max objections
        return $users_courses_objections;
    }
    //2
    public function getCourseWithNumOfObservation(){//get all course with num of objections ordered min
        $arr_keys_courses_num_objections_orderd=[];
        foreach ($this->courses->getCourses() as $course_id){
            $num=0;
            foreach ($this->arr_users_objetions_orderd as $arr_courses_ids)
                if(in_array($course_id,$arr_courses_ids))
                    $num++;
            $arr_keys_courses_num_objections_orderd[$course_id]=$num;
        }//dump($arr_keys_courses_num_objections_orderd);
        uasort($arr_keys_courses_num_objections_orderd,fn($a,$b)=>$a<$b);//sort via the course that have max objections
        //dd($arr_keys_courses_num_objections_orderd);
        return $arr_keys_courses_num_objections_orderd;
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

    public function setUsersWithSameTimeNodes(){//link users node with courses that have not objections of them in latest rotation
        foreach ($this->arr_keys_users_objections_orderd as $user_id) {
            $key_user=$this->getKeyFromArray($user_id,$this->arr_keys_users_objections_orderd);
            foreach ($this->arr_keys_courses_num_objections_orderd as $course_id) {
                $key_course=$this->getKeyFromArray($course_id,$this->arr_keys_courses_num_objections_orderd);
                if(!in_array($course_id,$this->arr_users_objetions_orderd[$user_id]))
                    $this->arr_graph[$key_user+1][$this->members->getLength()+$this->arr_same_time_courses[$key_course]+1]=1;
            }
        }
    }
    public function coursesWithArrDateAndTime(){
        $arr_courses_idx_date_time=[];
        for ($i=0; $i < $this->courses->getLength() ; $i++) {
            $curr_course=Course::where('id',$this->courses->getCourses()[$i])->first();//depend on the `$this->courses->getCourses()` that is ordered via date
            $arr_courses_idx_date_time[$i]['date']=$this->rotation->coursesProgram()->where('id',$curr_course->id)->first()->pivot->date;
            $arr_courses_idx_date_time[$i]['time']=$this->rotation->coursesProgram()->where('id',$curr_course->id)->first()->pivot->time;
            $arr_courses_idx_date_time[$i]['duration']=$this->rotation->coursesProgram()->where('id',$curr_course->id)->first()->pivot->duration;
        }
        return $arr_courses_idx_date_time;
    }
    public function coursesInSameTimes(){//this method rely the courses that orderd via date`$this->courses->getCourses()` with the the courses that orderd via objections array `$this->arr_keys_courses_num_objections_orderd` that orderd via objections,each index in this array that is returned from this method correspond to the index in the array `$this->arr_keys_courses_num_objections_orderd`
        $same_times=$this->arr_keys_courses_num_objections_orderd;
        $same_times[$this->getKeyFromArray($this->courses->getCourses()[0],$this->arr_keys_courses_num_objections_orderd)]=$counter=0;
        for ($i=1; $i < $this->courses->getLength() ; $i++) {
            $curr_date=$this->arr_courses_idx_date_time[$i]['date'];
            $curr_time=$this->arr_courses_idx_date_time[$i]['time'];
            $curr_duration=$this->arr_courses_idx_date_time[$i]['duration'];

            $pre_date=$this->arr_courses_idx_date_time[$i-1]['date'];
            $pre_time=$this->arr_courses_idx_date_time[$i-1]['time'];
            $pre_duration=$this->arr_courses_idx_date_time[$i-1]['duration'];

            if($pre_date==$curr_date &&
                ( 
                    ($pre_time == $curr_time) || ( strtotime($pre_time) > strtotime($curr_time) && $pre_time < gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration)) ) || 
                    ( strtotime($pre_time) < strtotime($curr_time) && $curr_time < gmdate('H:i:s',strtotime($pre_time)+strtotime($pre_duration)) ) 
                )
             ){
                //dump("same_time",$pre_time ,$pre_time,"------------------------------------");
                $same_times[$this->getKeyFromArray($this->courses->getCourses()[$i],$this->arr_keys_courses_num_objections_orderd)]=$same_times[$this->getKeyFromArray($this->courses->getCourses()[$i-1],$this->arr_keys_courses_num_objections_orderd)];
                continue;
            }
            $same_times[$this->getKeyFromArray($this->courses->getCourses()[$i],$this->arr_keys_courses_num_objections_orderd)]=++$counter;
            //dump("not_same_time",$pre_time ,$pre_time,"+++++++++++++++++++++++++++++++");
        }
        $num_distict_times=$same_times[count($same_times)-1]+1;//count(array_unique($same_times));

        return array($same_times,$num_distict_times);
    }
    // public function coursesInSameTimes(){//old generate ERROR
    //     $same_times[0]=$counter=0;
    //     for ($i=1; $i < $this->courses->getLength() ; $i++) {
    //         $curr_date=$this->arr_courses_idx_date_time[$i]['date'];
    //         $curr_time=$this->arr_courses_idx_date_time[$i]['time'];
    //         $curr_duration=$this->arr_courses_idx_date_time[$i]['duration'];

    //         $pre_date=$this->arr_courses_idx_date_time[$i-1]['date'];
    //         $pre_time=$this->arr_courses_idx_date_time[$i-1]['time'];

    //         if($pre_date==$curr_date &&
    //             ( 
    //                 ( $pre_time>=$curr_time && $pre_time <= gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration)) ) || 
    //                 ( $pre_time<=$curr_time && $pre_time >= gmdate('H:i:s',strtotime($curr_time)+strtotime($curr_duration)) ) 
    //             )
    //          ){
    //             $same_times[$i]=$same_times[$i-1];
    //             continue;
    //         }
    //         $same_times[$i]=++$counter;
    //     }
    //     $num_distict_times=$same_times[count($same_times)-1]+1;//count(array_unique($same_times));

    //     return array($same_times,$num_distict_times);
    // }
    public function setSameTimeNodesToCourses(){
        foreach ($this->arr_same_time_courses as $course_index => $same_time_index)
            $this->arr_graph[$this->members->getLength()+$same_time_index+1][$this->members->getLength()+$this->count_arr_same_time_courses+$course_index+1]=1;
    }

    public function setSameTimeNodesToCoursesAfterDfs(){
        foreach ($this->arr_same_time_courses as $course_index => $same_time_index)
            $this->arr_graph[$this->members->getLength()+$same_time_index+1][$this->members->getLength()+$this->count_arr_same_time_courses+$course_index+1]=$this->arr_courses_with_count_of_rooms[$this->arr_keys_courses_num_objections_orderd[$course_index]];
    }

    public function getCoursesRooms(){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms=[];
        foreach ($this->rotation->coursesProgram()->get() as $course) {
            $rooms_course=[];
            foreach ($course->distributionRoom()->wherePivot('rotation_id',$this->rotation->id)->get() as $room)
                array_push($rooms_course,$room->id);
                
            $courses_rooms[$course->id]=$rooms_course;
        }
        return $courses_rooms;
    }
    public function setCoursesRooms(){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms_ids=$this->getCoursesRooms();
        foreach ($courses_rooms_ids as $course_id => $rooms_ids) {
            $key_course=$this->getKeyFromArray($course_id,$this->arr_keys_courses_num_objections_orderd);
            foreach ($rooms_ids as $room_id) {
                $key_room=$this->getKeyFromArray($room_id,$this->rooms->getRooms());
                $this->arr_graph[$this->members->getLength()+$this->count_arr_same_time_courses+$key_course+1][$this->members->getLength()+$this->count_arr_same_time_courses+$this->courses->getLength()+$key_room+1]=1;
            }
        }
    }
    public function getCoursesWithCountOfRooms(){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms_ids=$this->getCoursesRooms();
        $courses_with_count_rooms=[];
        foreach ($this->arr_keys_courses_num_objections_orderd as $course_id)
            $courses_with_count_rooms[$course_id]=count($courses_rooms_ids[$course_id]);
            
        return $courses_with_count_rooms;
    }

    public function dfsOnSameTimeNodes(){//remove link to the common rooms that are common between more than course in the same time
        for ($i=0; $i < $this->count_arr_same_time_courses; $i++)
                $dfs=new Dfs($this->arr_graph,$this->members->getLength()+$i+1);
    }

    public function linkRoomsWithSink(){//link rooms nodes with the sink node
        for ($i=0; $i < $this->rooms->getLength(); $i++)
            $this->arr_graph[$this->members->getLength()+$this->count_arr_same_time_courses+$this->courses->getLength()+$i+1][$this->length_graph-1]=PHP_INT_MAX;
    }

    public function getKeyFromArray(int $valueE,array $arr){//get the key corresponding with the id of the first type parameter in the second array parameter
        foreach ($arr as $key => $value)
            if($value === $valueE)
                return $key;
    }

    public function applyMaxFlowAlgorithm(){
        $obj_max = new MaxFlow($this->length_graph,$this->members->getMembers(),$this->courses->getCourses(),$this->count_arr_same_time_courses);
        $paths=$obj_max->fordFulkerson($this->arr_graph, 0, $this->length_graph-1);
        //dd($this->arr_graph,$paths,'sameTime',$this->arr_same_time_courses,'courses',$this->arr_keys_courses_num_objections_orderd,'users',$this->arr_users_objetions_orderd);
        $pathsInfo=$this->convertFordFulkersonPaths($paths);
        // if($this->type->name == "Observer"){
        //     dd("Paths",$pathsInfo,$this->arr_keys_users_objections_orderd,$this->arr_keys_courses_num_objections_orderd);
        // }
        //dump("Paths",$pathsInfo,$this->arr_keys_users_objections_orderd,$this->arr_keys_courses_num_objections_orderd);
        //dd($paths);
        return array($paths,$pathsInfo);
    }
    
    public function convertFordFulkersonPaths(array $paths){//convert the indeces paths to real index corresponding to users ,courses ,rooms
            $pathsInfo=[];
            $num_members=$this->members->getLength();
            $num_courses=$this->courses->getLength();
            $num_same_times=$this->count_arr_same_time_courses;
            //$pathsInfo['num_members']=$num_members;
            for ($i=1; $i <=$num_members; $i++) {
                //$observations_num=0;
                foreach ($paths as $path) {
                    
                    if($i == $path[0]){
                        $pathsInfo['users_observations'][$this->arr_keys_users_objections_orderd[$i-1]][]=[
                            //'granted_observations_num'=>++$observations_num,
                            //'rotation' =>$this->rotation->id,
                            //'actual_observations_num'=>User::where('id',$this->arr_keys_users_objections_orderd[$i-1])->first()->number_of_observation,
                            
                            'course' =>$this->arr_keys_courses_num_objections_orderd[$path[2]-$num_same_times-$num_members-1],
                            'room' =>$this->rooms->getRooms()[$path[3]-$num_courses-$num_same_times-$num_members-1],
                            'date'=>Course::where('id',$this->arr_keys_courses_num_objections_orderd[$path[2]-$num_same_times-$num_members-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->date,
                            'time'=>Course::where('id',$this->arr_keys_courses_num_objections_orderd[$path[2]-$num_same_times-$num_members-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->time,
                            'duration'=>Course::where('id',$this->arr_keys_courses_num_objections_orderd[$path[2]-$num_same_times-$num_members-1])->first()->rotationsProgram()->where('id',$this->rotation->id)->first()->pivot->duration,
                            'roleIn'=>$this->type->name
                        ];
                    }
                }
            }
            return $pathsInfo;
    }
}