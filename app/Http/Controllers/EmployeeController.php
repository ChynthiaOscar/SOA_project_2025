<?php

// app/Http/Controllers/EmployeeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function showForm()
    {
        return view('/pages/service-employee/employee/register');
    }

    public function store(Request $request)
    {
        // Validasi hanya field yang diisi user
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employee_data,email',
            'password' => 'required|string|min:6',
        ]);

        // Simpan ke database dengan nilai default untuk role dan salary
        Employee::create([
            'name' => $validated['name'],
            'role' => 'unassign', // default value
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'salary_per_shift' => 0, // default value
        ]);

        return redirect('/register')->with('success', 'Employee registered successfully!');
    }
}
