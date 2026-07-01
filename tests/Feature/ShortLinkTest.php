<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\User;
use App\Services\ShortLinkService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShortLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_short_link(): void
    {
        $user = User::factory()->create();
        $service = app(ShortLinkService::class);

        $link = $service->create($user, 'https://example.com/page');

        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'original_url' => 'https://example.com/page',
        ]);
        $this->assertEquals(6, strlen($link->short_code));
        $this->assertStringContainsString($link->short_code, $link->short_url);
    }

    public function test_short_codes_are_unique(): void
    {
        $user = User::factory()->create();
        $service = app(ShortLinkService::class);

        $link1 = $service->create($user, 'https://example.com/1');
        $link2 = $service->create($user, 'https://example.com/2');

        $this->assertNotEquals($link1->short_code, $link2->short_code);
    }

    public function test_user_can_delete_own_link(): void
    {
        $user = User::factory()->create();
        $link = Link::factory()->create(['user_id' => $user->id]);

        $link->delete();

        $this->assertDatabaseMissing('links', ['id' => $link->id]);
    }
}
