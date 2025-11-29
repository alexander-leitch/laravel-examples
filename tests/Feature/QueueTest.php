<?php

namespace Tests\Feature;

use App\Jobs\ProcessDemoJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test queue demo page loads successfully.
     */
    public function test_queue_demo_page_loads(): void
    {
        $response = $this->get('/queue-demo');
        $response->assertStatus(200);
        $response->assertSee('Queue System Demo');
    }

    /**
     * Test job can be dispatched to queue.
     */
    public function test_job_can_be_dispatched(): void
    {
        Queue::fake();

        $response = $this->postJson('/queue-demo/dispatch', [
            'task_name' => 'Test Job',
            'duration' => 10,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        Queue::assertPushed(ProcessDemoJob::class, function ($job) {
            return $job->taskName === 'Test Job' && $job->duration === 10;
        });
    }

    /**
     * Test job dispatching creates queue entry.
     */
    public function test_job_dispatching_works(): void
    {
        Queue::fake();

        ProcessDemoJob::dispatch('Test Job', 5);

        Queue::assertPushed(ProcessDemoJob::class, function ($job) {
            return $job->taskName === 'Test Job' && $job->duration === 5;
        });
    }

    /**
     * Test get jobs endpoint returns pending jobs.
     */
    public function test_get_jobs_endpoint(): void
    {
        // Dispatch a job
        $this->postJson('/queue-demo/dispatch', [
            'task_name' => 'Test Job',
            'duration' => 5,
        ]);

        $response = $this->getJson('/queue-demo/jobs');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'pending_jobs',
            'jobs',
        ]);
    }

    /**
     * Test job executes successfully.
     */
    public function test_job_executes(): void
    {
        $job = new ProcessDemoJob('Test Execution', 0); // 0 duration for speed

        // Job should not throw exception
        $this->expectNotToPerformAssertions();
        $job->handle();
    }

    /**
     * Test job dispatch validation.
     */
    public function test_job_dispatch_with_default_values(): void
    {
        Queue::fake();

        $response = $this->postJson('/queue-demo/dispatch', []);

        $response->assertStatus(200);

        Queue::assertPushed(ProcessDemoJob::class);
    }
}
