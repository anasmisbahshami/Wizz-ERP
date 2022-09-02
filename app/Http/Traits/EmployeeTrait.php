<?php

namespace App\Http\Traits;
use App\Models\Employee;
use Auth;

trait EmployeeTrait {
    public static function getEmployeeId() {
        $employee = Employee::where('user_id', Auth::user()->id)->first();
        $id = ($employee->id);
        return $id;
    }
}