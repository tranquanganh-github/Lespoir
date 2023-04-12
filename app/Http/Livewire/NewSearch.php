<?php

namespace App\Http\Livewire;

use App\Models\News;
use Livewire\Component;


class NewSearch extends Component
{
//    protected $listeners = ['refresh-me' => '$refresh'];
    public $search;
    public $message;
    protected $queryString = ['search'];
    public function render()
    {
        $news = $this->search();
        return view('livewire.new-search',compact("news"));
    }

    function search(){
        if ($this->search){
            $news = News::search($this->search)->paginate(6);
        }else{
            $news = News::select()->orderBy('created_at')->paginate(6);
        }
        return $news;
    }
}
