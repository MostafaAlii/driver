<?php
namespace  App\Repositories\Contracts;
use App\Models\Company;
use Illuminate\Http\Request;
use App\DataTables\CompanyDataTable;
use App\Http\Requests\Dashboard\CompanyRequest;
interface CampanyRepositoryInterface {
    public function index(CompanyDataTable $companyDataTable);
    public function show(string $id);
    public function store(CompanyRequest $request);
    public function updateStatus(Request $request, Company $company);
    public function destroy(Request $request, $id);
    public function update(Request $request, $id);
}