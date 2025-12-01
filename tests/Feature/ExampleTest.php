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
        // Skip in CI where Vite build manifest may not be available
        if (! file_exists(public_path('build/manifest.json'))) {
            $this->markTestSkipped('View tests skipped when Vite manifest is not available');
        }

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
