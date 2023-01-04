<?php

namespace App\Http\Controllers\MaxFlow;

use App\Http\Controllers\Controller;
use SplStack;

class Dfs extends Controller
{
    private array $adj;
    private array $status;
    public array $treeEdges;
    private array $parents;
    private int $curr_node;
    public function __construct(array & $adj, int $node){
        $this->adj = &$adj;
        for ($i = 0; $i < count($this->adj); $i++){
            $this->status[$i]=1;
            $this->parents[$i]=-1;
        }
        $this->curr_node=$node;
        $this->dfsIterative($this->curr_node);
    }
    public function dfsIterative(int $node) {
        $this->status[$node]=2;
        for ( $j = 0; $j < count($this->status); $j++){
            if($this->adj[$node][$j] == 1){
                if($this->status[$j]==1){
                    $this->treeEdges[]=[$node,$j];
                    $this->parents[$j]=$node;
                    $this->dfsIterative($j);
                }elseif($this->status[$j]==2){
                    $this->adj[$node][$j]=0;//remove link to the common rooms that are common between more than course in the same time
                }
            }
        }
        // $path=array();
        // foreach($adj[$node] as $key => $adjV) {
        //     if($adjV > 0) {
        //         $this->dfsIterative($adj, $key, $paths);
        //         $path[$node]=$paths;
        //     }
        // }
        // if(count($path))
        // $paths[$node]=$path;
        // ksort($paths);
        // return $paths;
    }

    public function is_exist_path_to($end){
        if($this->parents[$end]==-1)
            return false;
        else
            return true;
    }

    public function get_path_to($end){
        $path=array();
        $parent=$this->parents[$end];
        if($parent == -1){
            return $path;
            dd("There is no path to this node");
        }else{
            array_push($path,$end);
        }
        while($parent !=-1){
            array_push($path,$parent);
            $parent=$this->parents[$parent];//get key for spesific element in array
        }
        asort($path);
        return $path;
    }
}

// class Graph {
//     public $adj;
//     public $size;
//  }