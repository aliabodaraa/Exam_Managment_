<?php

namespace App\Http\Livewire;

use Livewire\Component;
//  use Livewire\WithPagination;
use App\Models\User;
class Search extends Component
{
    //  use WithPagination;
    public $searchTerm='';
    public function mount()
    {
        //dd($this->doSomething());
        return view('livewire.search');
    }
    public function render()
    {
        return view('livewire.search',['users' => User::search($this->searchTerm)]);//->paginate(6);
        // ['users' => User::when($this->searchTerm,function($query, $searchTerm){
        //     return $query->where('username','LIKE',"%$searchTerm%");
        // })//->paginate(6)
        // ]);
    }
    public function doSomething(){
        dd(0);
    }
}
