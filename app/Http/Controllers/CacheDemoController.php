<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheDemoController extends Controller
{
    public function index()
    {
        return view('cache-demo');
    }

    public function getData(Request $request)
    {
        $useCache = $request->input('use_cache', true);
        $cacheKey = 'demo_expensive_data';

        $startTime = microtime(true);

        if ($useCache) {
            $data = Cache::remember($cacheKey, 3600, function () {
                return $this->expensiveOperation();
            });
            $cached = Cache::has($cacheKey);
        } else {
            Cache::forget($cacheKey);
            $data = $this->expensiveOperation();
            $cached = false;
        }

        $executionTime = round((microtime(true) - $startTime) * 1000, 2);

        return response()->json([
            'data' => $data,
            'execution_time_ms' => $executionTime,
            'was_cached' => $cached,
            'cache_key' => $cacheKey,
        ]);
    }

    public function clearCache()
    {
        Cache::flush();

        return response()->json([
            'success' => true,
            'message' => 'Cache cleared successfully!',
        ]);
    }

    private function expensiveOperation()
    {
        // Simulate an expensive database query or computation
        sleep(3);

        return [
            'users' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
                ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
                ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com'],
            ],
            'generated_at' => now()->toDateTimeString(),
            'note' => 'This data took 3 seconds to generate',
        ];
    }
}
