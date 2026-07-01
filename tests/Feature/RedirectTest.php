<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\LinkClick;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_short_link_redirects_to_original_url(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->create([
            'user_id' => $user->id,
            'original_url' => 'https://example.com/target',
            'short_code' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://example.com/target');
    }

    public function test_redirect_records_click_statistics(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->create([
            'user_id' => $user->id,
            'original_url' => 'https://example.com/target',
            'short_code' => 'xyz789',
        ]);

        $this->get('/xyz789');

        $this->assertDatabaseCount('link_clicks', 1);
        $this->assertDatabaseHas('link_clicks', [
            'link_id' => $link->id,
        ]);

        $click = LinkClick::first();
        $this->assertNotNull($click->ip_address);
        $this->assertNotNull($click->clicked_at);
        $this->assertSame('Europe/Moscow', $click->clicked_at->timezone->getName());
    }

    public function test_app_timezone_is_configured(): void
    {
        $this->assertSame('Europe/Moscow', config('app.timezone'));
        $this->assertSame('Europe/Moscow', now()->timezone->getName());
    }

    public function test_unknown_short_code_returns_404(): void
    {
        $response = $this->get('/notfound');

        $response->assertNotFound();
    }
}
