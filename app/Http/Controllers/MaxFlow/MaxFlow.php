<?php

namespace App\Http\Controllers\MaxFlow;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;
class MaxFlow extends Controller
{
    public static int $V; // Number of vertices in graph

    public function __construct(array $graph,int $length_graph){
        Self::$V = $length_graph;
    }
    
    public function bfs(array &$rGraph,int $s, int $t, array &$parent) : bool {
        // Create a visited array and mark all vertices as
        // not visited
        $visited=[];
        for ($i = 0; $i < Self::$V; ++$i)
            $visited[$i] = false;
 
        // Create a queue, enqueue source vertex and mark
        // source vertex as visited
        $queue=[];
        array_push($queue,$s);
        $visited[$s] = true;
        $parent[$s] = -1;

        // Standard BFS Loop
        while (count($queue) != 0) {
            // Asem Very important !!!!!!!!!!!!!!!!!!!!!!!!!!!!
            $u = array_shift($queue);
 
            for ( $v = 0; $v < Self::$V; $v++) {
                //dump($visited);
                if ($visited[$v] == false
                    && $rGraph[$u][$v] > 0) {
                    // If we find a connection to the sink
                    // node, then there is no point in BFS
                    // anymore We just have to set its parent
                    // and can return true
                    if ($v == $t) {
                        $parent[$v] = $u;
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
            for ($v = $t; $v != $s; $v = $parent[$v]) {//dump($u,$v);
                array_push($path,$v);
                $u = $parent[$v];
                $rGraph[$u][$v] -= $path_flow;
                $rGraph[$v][$u] += $path_flow;
                //dump($rGraph[$u][$v]);
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