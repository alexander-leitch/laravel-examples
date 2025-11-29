<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class QueueStatus extends Component
{
    public $jobs = [];

    public $pendingCount = 0;

    public function mount()
    {
        $this->refreshJobs();
    }

    #[On('refreshJobs')]
    public function refreshJobs()
    {
        $this->jobs = \DB::table('jobs')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();

        $this->pendingCount = count($this->jobs);
    }

    public function render()
    {
        return view('livewire.queue-status');
    }
}
