<?php
namespace  App\Repositories\Contracts;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\DataTables\AdminDataTable;
use App\Http\Requests\Dashboard\AdminValidatationRequest;

interface AdminRepositoryInterface {
    public function index(AdminDatatable $adminDataTable);
    public function create();
    public function store(AdminValidatationRequest $request);
    public function show(string $id);
    public function updateStatus(Request $request, Admin $admin);
    public function update(Request $request, $id);
    public function destroy(Request $request, $id);
    public function destroy_all();
    
}