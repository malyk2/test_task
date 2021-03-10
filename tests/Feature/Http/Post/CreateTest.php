<?php

namespace Tests\Feature\Http\Post;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
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
        $response = $this->json('POST', '/api/posts', $data['data']);

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
                'required' => [
                    'data' => [],
                    'keys' => ['title'],
                ],
            ],
            [
                'not string array' => [
                    'data' => [
                        'title' => ['foo' => 'bar']
                    ],
                    'keys' => ['title'],
                ],
            ],
            [
                'not string file' => [
                    'data' => [
                        'title' => UploadedFile::fake()->create('test.txt')
                    ],
                    'keys' => ['title'],
                ],
            ],
            [
                'max' => [
                    'data' => [
                        'title' => Str::random(257),
                    ],
                    'keys' => ['title'],
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
        $response = $this->json('POST', '/api/posts', ['title' => 'Some title']);
        $response
            ->assertStatus(201);
    }
}
