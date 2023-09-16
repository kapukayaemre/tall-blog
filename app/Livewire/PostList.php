<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url()] /*** Add to URL */
    public string $sort = "DESC";

    #[Url()]
    public string $search = "";

    public function setSort($sort)
    {
        $this->sort = ($sort === "DESC") ? "DESC" : "ASC";
    }

    #[On("search")] /*** Listen searches */
    public function updateSearch($search)
    {
        $this->search = $search;
    }

    #[Computed()] /*** Access post on feature methods */
    public function posts()
    {
        return Post::published()
            ->orderBy("published_at", $this->sort)
            ->where("title", "LIKE", "%{$this->search}%")
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
