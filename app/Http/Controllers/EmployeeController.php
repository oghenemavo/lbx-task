<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFileRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::get();
        return response()->json([
            'status' => true,
            'data' => $employees,
            'message' => 'fetched employees successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeFileRequest $request)
    {
        // dump(11);
        // $validatedData = $request->validated();
        $file = $request->file('employees');
        $name = time() . '.' . $file->extension();
        $path = public_path() . '/files';
        $file->move($path, $name);
        return response()->json([
            'status' => true,
            'data' => $name,
            'message' => 'uploaded employees file successfully'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findorfail($id);
        return response()->json([
            'status' => true,
            'data' => $employee,
            'message' => 'fetched employee successfully'
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findorfail($id);
        $employee->delete();
        return response()->json([
            'status' => true,
            'message' => 'deleted employee successfully'
        ], Response::HTTP_OK);
    }
}
