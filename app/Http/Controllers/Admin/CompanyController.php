<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\CommonHelper;
use App\Http\Requests\Admin\Companies\StoreOrUpdateRequest;
use App\Mail\NewCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    /**
     * @var CommonHelper
     */
    private $commonHelper;

    public function __construct(CommonHelper $commonHelper)
    {
        $this->commonHelper = $commonHelper;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.companies.index', ['data' => Company::get(['id', 'name', 'email', 'website'])->toArray()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.companies.edit-add', ['data' => ['company' => null, 'type' => 'Add']]);
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

            $company = Company::create([
                'name' => $request->company_name,
                'email' => !empty($request->company_email) ? $request->company_email : '',
                'website' => !empty($request->company_website) ? $request->company_website : '',
                'logo' => !empty($request->company_logo) ?
                    $this->commonHelper->uploadedFile('companies', $request->company_logo)
                    : '',
            ]);

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('companies.create')->with('error', 'Company not create');
        }

        try {
            Mail::to('joinToItTest@mail.com')->send(new NewCompany($company));
        } catch (\Throwable $throwable) {
            Log::error('email error ' . $throwable->getMessage());
        }

        return redirect()->route('companies.index')->with('message', 'Company created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(int $id)
    {
        $company = Company::find($id);

        if (empty($company))
            return redirect()->route('companies.index')->with('error', 'Company not found');

        return view('admin.companies.read', ['data' => ['company' => $company]]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(int $id)
    {
        $company = Company::find($id);

        if (empty($company))
            return redirect()->route('companies.index')->with('error', 'Company not found');

        return view('admin.companies.edit-add', ['data' => ['company' => $company, 'type' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreOrUpdateRequest $request
     * @param int $id
     */
    public function update(StoreOrUpdateRequest $request, int $id)
    {
        $company = Company::find($id);

        if (empty($company))
            return redirect()->route('companies.edit', $id)->with('error', 'Company not found');

        try {

            $company->name = $request->company_name;

            if (!empty($request->company_email))
                $company->email = $request->company_email;

            if (!empty($request->company_website))
                $company->website = $request->company_website;

            if (!empty($request->company_logo)) {
                $this->commonHelper->deleteFile($company->logo);
                $company->logo = $this->commonHelper->uploadedFile('companies', $request->company_logo);
            }

            $company->save();

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('companies.edit', $id)->with('error', 'Company not update');
        }

        return redirect()->route('companies.index')->with('message', 'Company updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if (empty($company))
            return redirect()->route('companies.index')->with('error', 'Company not found');

        try {

            $this->commonHelper->deleteFile($company->logo);
            $company->delete();
            return redirect()->route('companies.index')->with('message', 'Company not destroy');

        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage());
            return redirect()->route('companies.index')->with('error', 'Company not destroy');
        }

    }
}
