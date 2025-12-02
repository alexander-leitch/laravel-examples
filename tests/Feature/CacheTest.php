<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test cache demo page loads successfully.
     * Skipped in CI as it requires Vite assets for Blade rendering.
     */
    public function test_cache_demo_page_loads(): void
    {
        // Skip in CI - Blade views with @vite can't resolve in test environment
        if (env('GITHUB_ACTIONS')) {
            $this->markTestSkipped('Blade view tests skipped in CI environment');
        }

        $response = $this->get('/cache-demo');
        $response->assertStatus(200);
        $response->assertSee('Cache System Demo');
    }

    /**
     * Test fetching data with cache enabled.
     */
    public function test_fetch_data_with_cache(): void
    {
        Cache::flush(); // Clear cache before test

        $response = $this->getJson('/cache-demo/data?use_cache=1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'execution_time_ms',
            'was_cached',
            'cache_key',
        ]);

        // Verify the cache key is correct
        $response->assertJson([
            'cache_key' => 'demo_expensive_data',
        ]);
    }

    /**
     * Test subsequent cache requests are faster.
     */
    public function test_cached_data_is_faster(): void
    {
        Cache::flush();

        // First request
        $response1 = $this->getJson('/cache-demo/data?use_cache=1');
        $time1 = $response1->json('execution_time_ms');

        // Second request (should be cached)
        $response2 = $this->getJson('/cache-demo/data?use_cache=1');
        $time2 = $response2->json('execution_time_ms');

        // Cached request should be significantly faster
        $this->assertLessThan($time1, $time2);
        $response2->assertJson([
            'was_cached' => true,
        ]);
    }

    /**
     * Test fetching data without cache.
     */
    public function test_fetch_data_without_cache(): void
    {
        $response = $this->getJson('/cache-demo/data?use_cache=0');

        $response->assertStatus(200);
        $response->assertJson([
            'was_cached' => false,
        ]);

        // Cache should not be used
        $this->assertFalse(Cache::has('demo_expensive_data'));
    }

    /**
     * Test clearing cache.
     */
    public function test_clear_cache(): void
    {
        // Set some cache
        Cache::put('test_key', 'test_value', 3600);

        $response = $this->postJson('/cache-demo/clear');

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Cache cleared successfully!',
        ]);

        // Verify cache was cleared
        $this->assertFalse(Cache::has('test_key'));
    }

    /**
     * Test cache stores correct data structure.
     */
    public function test_cache_data_structure(): void
    {
        Cache::flush();

        $response = $this->getJson('/cache-demo/data?use_cache=1');

        $response->assertJsonStructure([
            'data' => [
                'users',
                'generated_at',
                'note',
            ],
        ]);

        $data = $response->json('data');
        $this->assertIsArray($data['users']);
        $this->assertCount(3, $data['users']);
    }

    /**
     * Test cache key consistency.
     */
    public function test_cache_key_consistency(): void
    {
        Cache::flush();

        $response1 = $this->getJson('/cache-demo/data?use_cache=1');
        $response2 = $this->getJson('/cache-demo/data?use_cache=1');

        // Both requests should use the same cache key
        $this->assertEquals(
            $response1->json('cache_key'),
            $response2->json('cache_key')
        );
        $this->assertEquals('demo_expensive_data', $response1->json('cache_key'));
    }

    /**
     * Test performance improvement with cache.
     */
    public function test_performance_improvement(): void
    {
        Cache::flush();

        // First request (no cache)
        $response1 = $this->getJson('/cache-demo/data?use_cache=1');
        $time1 = $response1->json('execution_time_ms');

        // Second request (cached)
        $response2 = $this->getJson('/cache-demo/data?use_cache=1');
        $time2 = $response2->json('execution_time_ms');

        // Performance improvement should be significant (>90%)
        $improvement = (1 - ($time2 / $time1)) * 100;
        $this->assertGreaterThan(90, $improvement);
    }
}
