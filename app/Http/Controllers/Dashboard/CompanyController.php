<?php

namespace App\Http\Controllers\Dashboard;
use App\Models\Company;
use Illuminate\Http\Request;
use App\DataTables\CompanyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CompanyRequest;
use App\Repositories\Contracts\CampanyRepositoryInterface;

class CompanyController extends Controller
{
    public function __construct(protected CompanyDataTable $companyDataTable, protected CampanyRepositoryInterface $companyInterface) {
        $this->companyDataTable = $companyDataTable;
        $this->companyInterface = $companyInterface;
    }
    
    public function index(CompanyDataTable $companyDataTable) {
        return $this->companyInterface->index($companyDataTable);
    }

    public function store(CompanyRequest $request) {
        return $this->companyInterface->store($request);
    }

    public function show(string $id) {
        return $this->companyInterface->show($id);
    }

    public function updateStatus(Request $request, Company $company) {
        return $this->companyInterface->updateStatus($request, $company);
    }

    public function update(Request $request, string $id) {
        return $this->companyInterface->update($request, $id);
    }

    public function destroy(Request $request, $id) {
        return $this->companyInterface->destroy($request, $id);
    }
}
