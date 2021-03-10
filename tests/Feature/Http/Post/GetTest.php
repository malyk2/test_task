<?php

namespace Tests\Feature\Http\Post;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTest extends TestCase
{
    use RefreshDatabase;

    protected $post;

    protected function setUp(): void
    {
        parent::setUp();
        $this->post = Post::factory()->create();
    }

    /**
     * Test 404
     *
     * @test
     * @return void
     */
    public function notFound()
    {
        $response = $this->json('GET', '/api/posts/0');

        $response
            ->assertStatus(404);
    }

    /**
     * Test success
     *
     * @test
     * @return void
     */
    public function success()
    {
        $response = $this->json('GET', '/api/posts/' . ($id = $this->post->id));
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $id]);
    }
}
