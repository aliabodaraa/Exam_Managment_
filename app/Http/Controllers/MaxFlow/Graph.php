<?php

namespace App\Http\Controllers\MaxFlow;

use App\Http\Controllers\Controller;
use App\Models\Rotation;
use App\Http\Controllers\MaxFlow\EnumPersonType;
use App\Http\Controllers\MaxFlow\Members;
use App\Http\Controllers\MaxFlow\Courses;
use App\Http\Controllers\MaxFlow\MaxFlow;
use App\Http\Controllers\MaxFlow\Dfs;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\PHP;

class Graph extends Controller
{
    private Members $members;
    private Courses $courses;
    private Rooms $rooms;
    private Rotation $rotation;
    private array $graph_arr=[];
    private int $length_graph;

    public function __construct(EnumPersonType $type){
        $this->rotation=Rotation::latest()->first();
        $this->members=new Members($type,$this->rotation);
        $this->courses=new Courses($this->rotation);
        $this->rooms=new Rooms($this->rotation);
        $this->buildGraph();
    }

    public function buildGraph(){
        list($same_times,$num_distict_times)=$this->courses->coursesInSameTimes();
        $this->length_graph=$this->members->getLength()+$num_distict_times+$this->courses->getLength()+$this->rooms->getLength()+2;
        $this->initializeGraphWithZeroValues();//initalize the graph with zero values
        $this->linkSourceWithUsers($num_distict_times);//link source node with users via the observations of them
        $this->setUsersCoursesObjections();//link users node with courses that have not objections of them in latest rotation
        $this->setSameTimeNodesToCourses($same_times,$num_distict_times);//link each sameTimeNode with the courses that belong to it
        $this->setCoursesRooms($num_distict_times);//link each course with the rooms that belong to it
        $this->dfsOnSameTimeNodes();//remove link to the common rooms that collabrate between more than course in the same time
        $this->setSameTimeNodesToCoursesAfterDfs($same_times,$num_distict_times);
        $this->linkRoomsWithSink($num_distict_times);//link rooms nodes with the sink node
        $this->applyMaxFlowAlgorithm($this->graph_arr,$this->length_graph);
        dd( $this->graph_arr,
            $this->members->getMembers(),
            $this->courses->getCourses(),
            $this->rooms->getRooms(),
            $this->courses->coursesInSameTimes()[0],
            $this->getCoursesRooms()
        );

    }

    public function initializeGraphWithZeroValues(){//initalize the graph with zero values
        for ($i=0; $i < $this->length_graph; $i++)
            for ($j=0; $j < $this->length_graph; $j++)
                $this->graph_arr[$i][$j]=0;
    }

    public function linkSourceWithUsers(){//link source node with users via the observations of them
        for ($i=0; $i < $this->members->getLength(); $i++) {
            $user_id=$this->members->getMembers()[$i];
            $this->graph_arr[0][$i+1]=$this->members->getNumOfObservationsForSpecificMember($user_id);
        }
    }

    public function setUsersCoursesObjections(){//link users node with courses that have not objections of them in latest rotation
        $users_courses_objections=$this->getUsersWithObjectionsOnCourses();
        $obj_users=array_keys($users_courses_objections);
        foreach ($obj_users as  $user_id) {
            $key_user=$this->getKeyFromArray($user_id,$this->members->getMembers());       
            foreach ($this->courses->getCourses() as $course_id) {
                $isnot_objected=true;
                $key_course=$this->getKeyFromArray($course_id,$this->courses->getCourses());
                foreach ($users_courses_objections[$user_id] as  $value)
                    if($course_id == $value ){
                        $isnot_objected=false;
                        break;
                    }
                if($isnot_objected)
                    $this->graph_arr[$key_user+1][$this->members->getLength()+$this->courses->coursesInSameTimes()[0][$key_course]+1]=1;
            }
        }
    }

    public function setSameTimeNodesToCourses(array $same_times_arr, int $num_distict_times){
        foreach ($same_times_arr as $course_index => $same_time_index)
            $this->graph_arr[$this->members->getLength()+$same_time_index+1][$this->members->getLength()+$num_distict_times+$course_index+1]=1;
    }

    public function setSameTimeNodesToCoursesAfterDfs(array $same_times_arr, int $num_distict_times){
        foreach ($same_times_arr as $course_index => $same_time_index)
            $this->graph_arr[$this->members->getLength()+$same_time_index+1][$this->members->getLength()+$num_distict_times+$course_index+1]=count($this->getCoursesRooms()[$this->courses->getCourses()[$course_index]]);
    }

    public function setCoursesRooms(int $num_distict_times){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms_ids=$this->getCoursesRooms();
        foreach ($courses_rooms_ids as $course_id => $rooms_ids) {
            $key_course=$this->getKeyFromArray($course_id,$this->courses->getCourses());
            foreach ($rooms_ids as $room_id) {
                $key_room=$this->getKeyFromArray($room_id,$this->rooms->getRooms());
                $this->graph_arr[$this->members->getLength()+$num_distict_times+$key_course+1][$this->members->getLength()+$num_distict_times+$this->courses->getLength()+$key_room+1]=1;
            }
        }
    }

    public function dfsOnSameTimeNodes(){//remove link to the common rooms that collabrate between more than course in the same time
        list($same_times,$num_distict_times)=$this->courses->coursesInSameTimes();
        for ($i=0; $i < $num_distict_times; $i++)
                $dfs=new Dfs($this->graph_arr,$this->members->getLength()+$i+1);
    }

    public function linkRoomsWithSink(int $num_distict_times){//link rooms nodes with the sink node
        for ($i=0; $i < $this->rooms->getLength(); $i++)
            $this->graph_arr[$this->members->getLength()+$num_distict_times+$this->courses->getLength()+$i+1][$this->length_graph-1]=PHP_INT_MAX;
    }

    public function getKeyFromArray(int $valueE,array $arr){//get the key corresponding with the id of the first type parameter in the second array parameter
        foreach ($arr as $key => $value)
            if($value === $valueE)
                return $key;
    }

    public function getUsersWithObjectionsOnCourses(){//users with objections on courses in latest rotation [as edges]
        $users_courses_objections=[];
        $user_ids_objected=$this->rotation->usersObjection()->get()->pluck('id')->toarray();
        foreach($this->members->getMembers() as $member_id){
            $member=User::where('id',$member_id)->first();
            $courses_user=[];
            if(in_array($member_id,$user_ids_objected))
                if(in_array($member_id,$this->members->getMembers())){
                    $courses_user=[];
                    foreach ($member->coursesObjection()->wherePivot('rotation_id',$this->rotation->id)->get() as $course)
                        array_push($courses_user,$course->id);

                    $users_courses_objections[$member_id]=$courses_user;
                }
            $users_courses_objections[$member_id]=$courses_user;
        }
        return $users_courses_objections;
    }

    public function getCoursesRooms(){//courses with distributed rooms in latest rotation [as edges]
        $courses_rooms=[];
        foreach ($this->rotation->distributionCourse()->get() as $course) {
            $rooms_course=[];
            foreach ($course->distributionRoom()->wherePivot('rotation_id',$this->rotation->id)->get() as $room)
                array_push($rooms_course,$room->id);
                
            $courses_rooms[$course->id]=$rooms_course;
        }
        return $courses_rooms;
    }

    public function applyMaxFlowAlgorithm(){
        $m = new MaxFlow($this->graph_arr,$this->length_graph);
        $num_paths=$m->fordFulkerson($this->graph_arr, 0, $this->length_graph-1);
        dump("num_paths",$num_paths,$m->paths);
    }

}