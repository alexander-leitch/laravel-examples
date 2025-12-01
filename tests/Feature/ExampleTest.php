<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     * Skipped in CI as it requires Vite assets for Blade rendering.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        if (env('VITE_HOT_FILE') === 'false') {
            $this->markTestSkipped('View tests skipped in CI environment');
        }
        
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
