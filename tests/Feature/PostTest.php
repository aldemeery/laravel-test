<?php

namespace Tests\Feature;

use App\Events\ModeratedModelCreated;
use App\Jobs\ModerateText;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostRejected;
use App\Services\TextModerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->post = null;
    }

    public function tearDown(): void
    {
        $this->user->delete();

        if ($this->post) {
            $this->post->delete();
        }

        parent::tearDown();
    }

    public function testPostStatusIsPendingByDefault()
    {
        Event::fake();

        $response = $this->actingAs($this->user, 'api')->postJson('/api/posts', Post::factory()->make()->toArray());
        $this->post = Post::withoutGlobalScopes()->latest()->first();

        Event::assertDispatched(function (ModeratedModelCreated $event) {
            return $event->getModel()->id === $this->post->id;
        });

        $response->assertStatus(202);
        $this->assertEquals('pending', $this->post->status);
    }

    public function testPostsWithBadWordsAreRejected()
    {
        Notification::fake();

        $stub = $this->createStub(TextModerator::class);
        $stub->method('check')->willReturn(false);
        $this->instance(TextModerator::class, $stub);

        $response = $this->actingAs($this->user)->postJson('/api/posts', Post::factory()->make()->toArray());

        $this->post = Post::withoutGlobalScopes()->latest()->first();

        Notification::assertSentTo(
            $this->user,
            function (PostRejected $notification, $channels) {
                return $notification->getPost()->id === $this->post->id;
            }
        );

        $response->assertStatus(202);
        $this->assertEquals('rejected', $this->post->status);
    }

    public function testPostsWithGoodWordsAreApproved()
    {
        $stub = $this->createStub(TextModerator::class);
        $stub->method('check')->willReturn(true);
        $this->instance(TextModerator::class, $stub);

        $response = $this->actingAs($this->user)->postJson('/api/posts', Post::factory()->make()->toArray());

        $this->post = Post::withoutGlobalScopes()->latest()->first();

        $response->assertStatus(202);
        $this->assertEquals('approved', $this->post->status);
    }
}
