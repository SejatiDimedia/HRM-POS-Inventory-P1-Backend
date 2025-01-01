<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    // Get all shifts
    public function index()
    {
        $shifts = Shift::where('company_id', 1)->get();

        return response()->json([
            'message' => 'Shifts retrieved successfully',
            'shifts' => $shifts,
        ], 200);
    }

    // Get a specific shift by ID
    public function show($id)
    {
        $shift = Shift::where('company_id', 1)->find($id);

        if (!$shift) {
            return response()->json([
                'message' => 'Shift not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Shift retrieved successfully',
            'shift' => $shift,
        ], 200);
    }

    // Create a new shift
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shift_name' => 'required|string|max:255',
            'clock_in_time' => 'required|date_format:H:i:s',
            'clock_out_time' => 'required|date_format:H:i:s',
            'late_mark_after' => 'nullable|integer',
            'early_clock_in_time' => 'nullable|integer',
            'allow_clock_out_till' => 'nullable|integer',
            'self_clocking' => 'nullable|boolean',
        ]);

        $validated['late_mark_after'] = $validated['late_mark_after'] ?? 0;
        $validated['early_clock_in_time'] = $validated['early_clock_in_time'] ?? 0;
        $validated['allow_clock_out_till'] = $validated['allow_clock_out_till'] ?? 0;
        $validated['self_clocking'] = $validated['self_clocking'] ?? true;
        $validated['company_id'] = 1;

        $shift = Shift::create($validated);

        return response()->json([
            'message' => 'Shift created successfully',
            'shift' => $shift,
        ], 201);
    }

    // Update an existing shift
    public function update(Request $request, $id)
    {
        $shift = Shift::where('company_id', 1)->find($id);

        if (!$shift) {
            return response()->json([
                'message' => 'Shift not found'
            ], 404);
        }

        $validated = $request->validate([
            'shift_name' => 'sometimes|required|string|max:255',
            'clock_in_time' => 'sometimes|required|date_format:H:i:s',
            'clock_out_time' => 'sometimes|required|date_format:H:i:s',
            'late_mark_after' => 'nullable|integer',
            'early_clock_in_time' => 'nullable|integer',
            'allow_clock_out_till' => 'nullable|integer',
            'self_clocking' => 'nullable|boolean',
        ]);

        $validated['late_mark_after'] = $validated['late_mark_after'] ?? $shift->late_mark_after;
        $validated['early_clock_in_time'] = $validated['early_clock_in_time'] ?? $shift->early_clock_in_time;
        $validated['allow_clock_out_till'] = $validated['allow_clock_out_till'] ?? $shift->allow_clock_out_till;
        $validated['self_clocking'] = $validated['self_clocking'] ?? $shift->self_clocking;

        $shift->update($validated);

        return response()->json([
            'message' => 'Shift updated successfully',
            'shift' => $shift,
        ], 200);
    }

    // Delete a shift
    public function destroy($id)
    {
        $shift = Shift::where('company_id', 1)->find($id);

        if (!$shift) {
            return response()->json([
                'message' => 'Shift not found'
            ], 404);
        }

        $shift->delete();

        return response()->json([
            'message' => 'Shift deleted successfully',
        ], 200);
    }
}
