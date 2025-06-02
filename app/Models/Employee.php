<?php

// app/Models/Employee.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employee_data';

    protected $fillable = [
        'nama', 'role', 'email', 'password', 'salary_per_shift',
    ];
}
