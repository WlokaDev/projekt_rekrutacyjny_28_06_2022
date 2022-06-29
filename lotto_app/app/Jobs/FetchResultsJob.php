<?php

namespace App\Jobs;

use App\Models\Result;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class FetchResultsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \JsonException
     */

    public function handle()
    {
        $response = Http::get('http://www.mbnet.com.pl/dl_plus.txt');

        if($response->status() !== 200) {
            $this->fail('Failed to fetch results');
        }

        $data = [];

        foreach(explode("\n", $response->body()) as $line) {
            $line = trim($line);

            if($line) {
                $record = explode(" ", $line);

                $data[] = [
                    'external_id' => (int) $record[0],
                    'draw_date' => Carbon::parse($record[1])->format('Y-m-d'),
                    'numbers' => json_encode(Arr::map(explode(",", $record[2]), static function($element) {
                        return (int) $element;
                    }), JSON_THROW_ON_ERROR),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        foreach(array_chunk($data, 100) as $chunkedRecords) {
            $existingDates = Result
                ::query()
                ->whereIn('draw_date', array_column($chunkedRecords, 'draw_date'))
                ->pluck('draw_date')
                ->toArray();

            $filteredData = Arr::where($chunkedRecords, static function(array $record) use ($existingDates) {
                return !in_array($record['draw_date'], $existingDates);
            });

            Result::query()->insert($filteredData);
        }
    }
}
