<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays = Holiday::all();

        return response([
            'message' => 'Holidays information retrieved successfully',
            'data' => $holidays,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'date' => 'required|date',
            'is_weekend' => 'nullable|boolean',
        ]);

        $user = $request->user();

        $holiday = new Holiday();
        $holiday->company_id = 1;
        $holiday->name = $request->name;
        $holiday->year = $request->year;
        $holiday->month = $request->month;
        $holiday->date = $request->date;
        $holiday->is_weekend = $request->is_weekend ?? false;
        $holiday->created_by = $user->id;
        $holiday->save();

        return response([
            'message' => 'Holiday created successfully',
            'data' => $holiday,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $holiday = Holiday::find($id);

        if (!$holiday) {
            return response([
                'message' => 'Holiday not found',
            ], 404);
        }

        return response([
            'message' => 'Holiday retrieved successfully',
            'data' => $holiday,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'month' => 'required|integer|between:1,12',
            'date' => 'required|date',
            'is_weekend' => 'nullable|boolean',
        ]);

        $holiday = Holiday::find($id);

        if (!$holiday) {
            return response([
                'message' => 'Holiday not found',
            ], 404);
        }

        $user = $request->user();

        $holiday->company_id = 1;
        $holiday->name = $request->name;
        $holiday->year = $request->year;
        $holiday->month = $request->month;
        $holiday->date = $request->date;
        $holiday->is_weekend = $request->is_weekend ?? false;
        $holiday->created_by = $user->id;
        $holiday->save();

        return response([
            'message' => 'Holiday updated successfully',
            'data' => $holiday,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $holiday = Holiday::find($id);

        if (!$holiday) {
            return response([
                'message' => 'Holiday not found',
            ], 404);
        }

        $holiday->delete();

        return response([
            'message' => 'Holiday deleted successfully',
        ], 200);
    }
}
