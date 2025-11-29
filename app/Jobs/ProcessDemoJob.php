<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessDemoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $taskName = 'Demo Task',
        public int $duration = 10
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Log::info("Starting job: {$this->taskName}");

        // Simulate a long-running task
        sleep($this->duration);

        \Log::info("Completed job: {$this->taskName}");
    }
}
