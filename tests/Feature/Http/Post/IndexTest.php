<?php

namespace Tests\Feature\Http\Post;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test validation
     *
     * @test
     * @dataProvider getNotValidData
     * @return void
     */
    public function validation($data)
    {
        $response = $this->json(
            'GET',
            '/api/posts?' . http_build_query($data['data'])
        );
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors($data['keys']);
    }

    /**
     * Get not valid data
     *
     * @return array
     */
    public function getNotValidData()
    {
        return [
            [
                'not string array' => [
                    'data' => [
                        'filter' => [
                            'title' => ['foo' => 'bar']
                        ]
                    ],
                    'keys' => ['filter.title'],
                ],
            ],
            [
                'max' => [
                    'data' => [
                        'filter' => [
                            'title' => Str::random(257),
                        ]

                    ],
                    'keys' => ['filter.title'],
                ],
            ],
        ];
    }

    /**
     * Test success
     *
     * @test
     * @return void
     */
    public function success()
    {
        Post::factory()->count(4)->create();
        $response = $this->json('GET', '/api/posts');
        $response
            ->assertStatus(200)
            ->assertJsonCount(4, 'data');
    }

    /**
     * Test success
     *
     * @test
     * @return void
     */
    public function successFilterTitle()
    {
        Post::factory()->count(2)->create();
        Post::factory(['title' => 'first foo title'])->create();
        Post::factory(['title' => 'foo title second'])->create();
        $response = $this->json(
            'GET',
            '/api/posts/?' . http_build_query(['filter' => ['title' => 'foo']])
        );
        $response
            ->assertStatus(200)
            ->assertJsonCount(2, 'data');
    }
}
