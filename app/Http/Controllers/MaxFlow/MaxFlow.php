<?php

namespace App\Http\Controllers\MaxFlow;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;
class MaxFlow extends Controller
{
    public static int $V; // Number of vertices in graph
    //=======================  Asem  ===================
    public static $previous_user=0;
    public static $current_user=0;
    public static $count=0;
    public static $science_room_visited=false;
    private array $members;
    private array $courses;
    private array $rooms;
    private int $count_arr_same_time_courses;

    public static int $count_of_paths=0;
    //=====================  Asem  =====================
    public function __construct(int $length_graph,$members,$courses,$count_arr_same_time_courses , $rooms){
        Self::$V = $length_graph;
        $this->members=$members;
    
        $this->courses=$courses;
        $this->count_arr_same_time_courses=$count_arr_same_time_courses;

        ///dd($this->members ,"----",array_reverse($this->members ) );
        $this->rooms=$rooms;
    }
    public function bfs(array &$rGraph,int $s, int $t, array &$parent) : bool {
        // Create a visited array and mark all vertices as
        // not visited
        $visited=[];
        for ($i = 0; $i < Self::$V; ++$i)
            $visited[$i] = false;
       
        $visited[count($this->members)+$this->count_arr_same_time_courses+count($this->courses)+1]=Self::$science_room_visited;
        //if(Self::$current_user )
 
        // Create a queue, enqueue source vertex and mark
        // source vertex as visited
        $queue=[];
        array_push($queue,$s);
        $visited[$s] = true;
        $parent[$s] = -1;

        // Standard BFS Loop

        //$gg= count($this->members)+$this->count_arr_same_time_courses+count($this->courses)+1;
        //$ff= count($this->members)+$this->count_arr_same_time_courses+count($this->courses)+count($this->rooms);
        while (count($queue) != 0) {

            // Asem Very important !!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $u = array_shift($queue);

                        // Try to reduce the time execution

                        // if($u>=$gg   && $u<= $ff){
                        //     $parent[$t] = $u;
                        //     Self::$count=(Self::$count+1)%4;

                        //     Self::$current_user=$parent[$parent[$parent[$parent[$t]]]];
                        //     //dump($parent[$parent[$parent[$parent[$v]]]]);
                        
                        //     return true;
                        // }


                        //
 
            for ( $v = 0; $v < Self::$V; $v++) {
                ////dump($visited);
                if ($visited[$v] == false && $rGraph[$u][$v] > 0) {
                    // If we find a connection to the sink
                    // node, then there is no point in BFS
                    // anymore We just have to set its parent
                    // and can return true
                    if ($v == $t) {
                        $parent[$v] = $u;
                        Self::$count=(Self::$count+1)%4;

                        Self::$current_user=$parent[$parent[$parent[$parent[$v]]]];
                        //dump($parent[$parent[$parent[$parent[$v]]]]);
                        
                        return true;
                    }
                    array_push($queue,$v);
                    $parent[$v] = $u;
                    $visited[$v] = true;
                }
            }
        }
        // We didn't reach sink in BFS starting from source,
        // so return false
        return false;               
    }

    // Returns the maximum flow from s to t in the given
    // graph
    public function fordFulkerson(array & $graph, int $s, int $t) : array {
        $u=0;
        $v=0;
        $paths=[];

        
        // Create a residual graph and fill the residual
        // graph with given capacities in the original graph
        // as residual capacities in residual graph
 
        // Residual graph where rGraph[i][j] indicates
        // residual capacity of edge from i to j (if there
        // is an edge. If rGraph[i][j] is 0, then there is
        // not)
        $rGraph = [];
        for ($u = 0; $u < Self::$V; $u++)
            for ($v = 0; $v < Self::$V; $v++)
                $rGraph[$u][$v] = $graph[$u][$v];
 
        // This array is filled by BFS and to store path
        $parent =[];
        for ($v = 0; $v <Self::$V ; $v++) {
            $parent[$v] =0;
        }
 
        $max_flow = 0; // There is no flow initially
 
        // Augment the flow while there is path from source
        // to sink
        while ($this->bfs($rGraph, $s, $t, $parent)) {
            ////dump($parent);
            //===================Asem==============================================
            Self::$count_of_paths=Self::$count_of_paths+1;
            $pure_parent=array(); // Build pure_parent array with |path| whereas parent array with |V|
            $counter_index=4;
            $k=Self::$V-1;
            while($parent[$k] !== -1){
                $pure_parent[$counter_index] = $parent[$k];
                $k=$parent[$k];
                $counter_index--;
            }
            //dd($pure_parent);

            if(Self::$previous_user !==0 && Self::$previous_user !== Self::$current_user){
                //dump("new user",Self::$count_of_paths);
                Self::$count=0;
                Self::$science_room_visited=false;
            }else{ //same user
                if(Self::$count !== 0){
                    //dump("same user",Self::$count_of_paths);
                    $outdegree=0;
                    if($pure_parent[2]< count($this->members)+$this->count_arr_same_time_courses){ //Check if the there is another same_time
                        $next_course=-1;
                        for($i=count($this->members)+$this->count_arr_same_time_courses+1;$i<=count($this->members)+$this->count_arr_same_time_courses+count($this->courses);$i++){
                            if($rGraph[$pure_parent[2]][$i]>0 ){
                                $next_course=$i;
                                break;
                            }
                        }
                        if($next_course !== -1){
                            for($i =count($this->members)+$this->count_arr_same_time_courses+count($this->courses)+1;$i<Self::$V;$i++){
                                if($rGraph[$next_course][$i]==1){
                                    $outdegree++;
                                }
                            }
                        }
                        if($outdegree>1 && $rGraph[$next_course][count($this->members)+$this->count_arr_same_time_courses+count($this->courses)+1]==1){
                            Self::$science_room_visited=true;
                        }
                    }
                }else{
                    Self::$science_room_visited=false;
                }
            }
            Self::$previous_user = Self::$current_user;

            //===================Asem==============================================
            $path=array();
            // Find minimum residual capacity of the edhes
            // along the path filled by BFS. Or we can say
            // find the maximum flow through the path found.
            $path_flow = PHP_INT_MAX;
            for ($v = $t; $v != $s; $v = $parent[$v]) {
                $u = $parent[$v];
                $path_flow= min($path_flow, $rGraph[$u][$v]);
            }
            // update residual capacities of the edges and
            // reverse edges along the path
            for ($v = $t; $v != $s; $v = $parent[$v]) {////dump($u,$v);
                array_push($path,$v);
                $u = $parent[$v];
                $rGraph[$u][$v] -= $path_flow;
                //$rGraph[$v][$u] += $path_flow;-----------------------------------HERE the previous problem------------------
                ////dump($rGraph[$u][$v]);
            }
            // Add path flow to overall flow
            $max_flow += $path_flow;
            $path=array_reverse($path);
            
            array_push($paths,$path);
        }
        //Ali------move changes to the out
        $graph = $rGraph;
 
        // Return the overall flow
        return $paths;
    }

}