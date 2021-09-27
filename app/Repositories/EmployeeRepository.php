<?php
declare(strict_types=1);


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
            ->orderBy('employees.id', 'ASC')
            ->paginate(10);
    }

    /**
     * @return mixed
     */
    public function getCompanies()
    {
        return  Company::orderBy('name', 'ASC')->get(['id', 'name']);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getEmployee(int $id)
    {
        return Employee::join('companies as c', 'c.id', '=', 'employees.company_id')
            ->select('employees.id', 'employees.first_name', 'employees.last_name', 'c.name as company_name', 'employees.email', 'employees.phone')
            ->where('employees.id', $id)
            ->first();
    }



}
