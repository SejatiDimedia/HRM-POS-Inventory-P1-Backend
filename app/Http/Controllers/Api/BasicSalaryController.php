<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BasicSalary;
use Illuminate\Http\Request;

class BasicSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $basicSalary = BasicSalary::with('user')->orderBy('id', 'desc')->get();

        return response([
            'message' => 'Basic Salaries information retrieved successfully',
            'data' => $basicSalary,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'basic_salary' => 'required',
            'user_id' => 'required',
        ]);

        //$user = $request->user();

        $basicSalary = new BasicSalary();
        $basicSalary->company_id = 1;
        $basicSalary->user_id = $request->user_id;
        $basicSalary->basic_salary = $request->basic_salary;
        $basicSalary->save();

        return response([
            'message' => 'Basic Salary Create Successfully',
            'data' => $basicSalary,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $basicSalary = BasicSalary::find($id);

        if (!$basicSalary) {
            return response([
                'message' => 'Basic Salary not found',
            ], 404);
        }

        return response([
            'message' => 'Basic Salary retrieved successfully',
            'data' => $basicSalary,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'basic_salary' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $basicSalary = BasicSalary::find($id);

        if (!$basicSalary) {
            return response([
                'message' => 'Basic Salary not found',
            ], 404);
        }

        $basicSalary->company_id = 1;
        $basicSalary->user_id = $request->user_id;
        $basicSalary->basic_salary = $request->basic_salary;
        $basicSalary->save();

        return response([
            'message' => 'Basic Salary updated successfully',
            'data' => $basicSalary,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $basicSalary = BasicSalary::find($id);

        if (!$basicSalary) {
            return response([
                'message' => 'Basic Salary not found',
            ], 404);
        }

        $basicSalary->delete();

        return response([
            'message' => 'Basic Salary deleted successfully',
        ], 200);
    }
}
