<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employees\StoreOrUpdateRequest;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.employees.index', ['data' =>$this->employeeRepository->getEmployees()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $companies = $this->employeeRepository->getCompanies();
        return view('admin.employees.edit-add', ['data' => ['employee' => null, 'companies' => $companies, 'type' => 'Add']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreOrUpdateRequest $request)
    {
        try {

            Employee::create([
                'first_name' => $request->employee_first_name,
                'last_name' => $request->employee_last_name,
                'company_id' => $request->employee_company_id,
                'email' => !empty($request->employee_email) ? $request->employee_email : '',
                'phone' => !empty($request->employee_phone) ? $request->employee_phone : '',
            ]);

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('companies.create')->with('error', 'Employee not create');
        }

        return redirect()->route('employees.index')->with('message', 'Employee created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(int $id)
    {
        $employee = $this->employeeRepository->getEmployee($id);

        if (empty($employee))
            return redirect()->route('employees.index')->with('error', 'Employee not found');

        return view('admin.employees.read', ['data' => ['employee' => $employee]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $id)
    {
        $employee = Employee::find($id);

        if (empty($employee))
            return redirect()->route('employees.index')->with('error', 'Employee not found');

        $companies = $this->employeeRepository->getCompanies();
        return view('admin.employees.edit-add', ['data' => ['employee' => $employee, 'companies' => $companies, 'type' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreOrUpdateRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreOrUpdateRequest $request, $id)
    {
        $employee = Employee::find($id);

        if (empty($employee))
            return redirect()->route('employees.index')->with('error', 'Employee not found');

        try {

            $employee->first_name = $request->employee_first_name;
            $employee->last_name = $request->employee_last_name;
            $employee->company_id = $request->employee_company_id;

            if (!empty($request->employee_email))
                $employee->email = $request->employee_email;

            if (!empty($request->employee_phone))
                $employee->phone = $request->employee_phone;

            $employee->save();

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('employees.edit', $id)->with('error', 'Employee not updated');
        }

        return redirect()->route('employees.index')->with('message', 'Employee updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (empty($employee))
            return redirect()->route('employees.index')->with('error', 'Employee not found');

        try {

            $employee->delete();
            return redirect()->route('employees.index')->with('message', 'Employee not destroy');

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('employees.index')->with('error', 'Employee not destroy');
        }

    }
}
