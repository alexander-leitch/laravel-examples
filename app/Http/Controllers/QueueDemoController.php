<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessDemoJob;

class QueueDemoController extends Controller
{
    public function index()
    {
        return view('queue-demo');
    }

    public function dispatch(Request $request)
    {
        $taskName = $request->input('task_name', 'Demo Task ' . now()->format('H:i:s'));
        $duration = $request->input('duration', 10);

        ProcessDemoJob::dispatch($taskName, $duration);

        return response()->json([
            'success' => true,
            'message' => "Job '{$taskName}' dispatched successfully!",
            'info' => "The job will take approximately {$duration} seconds to complete."
        ]);
    }

    public function getJobs()
    {
        $jobs = \DB::table('jobs')->orderBy('id', 'desc')->limit(10)->get();

        return response()->json([
            'pending_jobs' => $jobs->count(),
            'jobs' => $jobs
        ]);
    }
}
