<?php

namespace App\Http\Controllers\v1;

use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function getResultsByDate(Request $request) : JsonResponse
    {
        $data = $request->validate([
            'date' => ['required', 'date']
        ]);

        $results = Result
            ::query()
            ->where('draw_date', $data['date'])
            ->select('numbers')
            ->first();

        if(!$results) {
            return $this->errorResponse(
                'No results found for this date',
                statusCode: 404
            );
        }

        return $this->successResponse(
            $results->numbers
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function getDatesByNumber(Request $request) : JsonResponse
    {
        $data = $request->validate([
            'number' => ['required', 'integer']
        ]);

        $results = Result
            ::query()
            ->whereJsonContains('numbers', (int) $data['number'])
            ->select('draw_date')
            ->get();


        if(!$results) {
            return $this->errorResponse(
                'No results found for this number',
                statusCode: 404
            );
        }

        return $this->successResponse([
            'dates' => $results->pluck('draw_date'),
            'count' => $results->count()
        ]);
    }
}
