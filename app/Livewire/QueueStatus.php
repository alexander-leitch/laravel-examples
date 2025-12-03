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
        $connection = config('queue.default');
        \Log::info("QueueStatus connection: " . $connection);

        if ($connection === 'database') {
            $this->jobs = \DB::table('jobs')
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get()
                ->toArray();
            $this->pendingCount = count($this->jobs);
        } else {
            // For Redis/other drivers, we can't easily list jobs, but we can get the count
            $this->pendingCount = \Illuminate\Support\Facades\Queue::size();
            $this->jobs = []; // Cannot easily list jobs from Redis
        }
    }

    public function render()
    {
        return view('livewire.queue-status');
    }
}
