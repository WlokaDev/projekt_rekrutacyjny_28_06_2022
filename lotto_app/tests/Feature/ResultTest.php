<?php

namespace Tests\Feature;

use App\Models\Result;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResultTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testFetchResultsWithProvidedDate()
    {
        $result = Result::factory()->create();

        $this->get('/api/v1/results/get-by-date?date=' . $result->draw_date)
            ->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'data' => $result->numbers,
                'code' => 200
            ]);
    }

    public function testValidationErrorWhenNotProvidedDataInFetchResultsByDate()
    {
        $this->get('/api/v1/results/get-by-date', [
            'Accept' => 'application/json'
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'date'
            ], 'data');
    }

    public function testValidationErrorWhenNotProvidedDataInFetchResultsByNumber()
    {
        $this->get('/api/v1/results/get-by-number', [
            'Accept' => 'application/json'
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'number'
            ], 'data');
    }

    public function testFetchResultsWithProvidedNumber()
    {
        $results = Result::factory(20)
            ->sequence(fn($sequence) => [
                'numbers' => $this->faker->randomElements([
                    3,
                ], 5, true),
                'draw_date' => $this->faker->unique()->date()
            ])
            ->create();


        $this->get('/api/v1/results/get-by-number?number=3')
            ->assertStatus(200)
            ->assertJson([
                'status' => 'ok',
                'data' => [
                    'dates' => $results->pluck('draw_date')->toArray(),
                    'count' => 20
                ],
                'code' => 200
            ]);
    }
}
