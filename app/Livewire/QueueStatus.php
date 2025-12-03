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

        if ($connection === 'database') {
            $this->jobs = \DB::table('jobs')
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get()
                ->toArray();
            $this->pendingCount = count($this->jobs);
        } else {
            // For Redis, fetch jobs from the queue
            $queueName = config('queue.connections.redis.queue', 'default');
            $this->pendingCount = \Illuminate\Support\Facades\Queue::size($queueName);
            
            // Get jobs from Redis queue
            $redis = \Illuminate\Support\Facades\Redis::connection();
            $prefix = config('database.redis.options.prefix', '');
            $key = $prefix . 'queues:' . $queueName;
            
            $rawJobs = $redis->lrange($key, 0, 9); // Get first 10 jobs
            $this->jobs = collect($rawJobs)->map(function ($job, $index) {
                $decoded = json_decode($job, true);
                $data = json_decode($decoded['data']['command'] ?? '{}', true);
                
                return (object) [
                    'id' => $decoded['uuid'] ?? $decoded['id'] ?? ($index + 1),
                    'queue' => $decoded['queue'] ?? 'default',
                    'payload' => $decoded['displayName'] ?? class_basename($decoded['data']['commandName'] ?? 'Job'),
                    'attempts' => $decoded['attempts'] ?? 0,
                    'created_at' => $decoded['pushedAt'] ?? time(),
                ];
            })->toArray();
        }
    }

    public function render()
    {
        return view('livewire.queue-status');
    }
}
