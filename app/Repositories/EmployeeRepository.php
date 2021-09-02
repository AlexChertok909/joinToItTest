<?php

namespace App\Repositories;



use App\Models\Company;
use App\Models\Employee;

class EmployeeRepository
{
    /**
     * @return mixed
     */
    public function getEmployees()
    {
        return Employee::join('companies as c', 'c.id', '=', 'employees.company_id')
            ->select('employees.id', 'employees.first_name', 'employees.last_name', 'c.name as company_name', 'employees.email', 'employees.phone')
            ->paginate(10);
    }

    /**
     * @return mixed
     */
    public function getCompanies()
    {
        return  Company::orderBy('name', 'ASC')->get(['id', 'name']);
    }

    public function getEmployee(int $id)
    {
        return Employee::join('companies as c', 'c.id', '=', 'employees.company_id')
            ->select('employees.id', 'employees.first_name', 'employees.last_name', 'c.name as company_name', 'employees.email', 'employees.phone')
            ->where('employees.id', $id)
            ->first();
    }



}
