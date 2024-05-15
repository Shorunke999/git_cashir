<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Events\DowntimeEvent;
use Illuminate\Support\Facades\Event;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_downtime_event_is_fired()
    {
        // Mock the event dispatcher
        Event::fake();

        // Dispatch the event directly
        Event::dispatch(DowntimeEvent::class);

        // Assert that the event was dispatched
        Event::assertDispatched(DowntimeEvent::class);
    }
}
