<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use App\DTOs\AdminDTO;
use Illuminate\Http\Request;
use App\DataTables\AdminDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Http\Requests\Dashboard\AdminValidatationRequest;

class AdminController extends Controller implements AdminRepositoryInterface
{
    public function __construct(protected AdminDatatable $adminDataTable, protected AdminRepositoryInterface $adminInterface) {
        $this->adminDataTable = $adminDataTable;
        $this->adminInterface = $adminInterface;
    }

    public function index(AdminDatatable $adminDataTable) {
        return $this->adminInterface->index($adminDataTable);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return $this->adminInterface->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminValidatationRequest $request) {
        return $this->adminInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        return $this->adminInterface->show($id);
    }

    /**
     * Update the specified resource status in storage.
     */
    public function updateStatus(Request $request, Admin $admin) {
        return $this->adminInterface->updateStatus($request, $admin);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        return $this->adminInterface->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id) {
        return $this->adminInterface->destroy($request, $id);
    }

    public function destroy_all() {
        return $this->adminInterface->destroy_all();
    }
}