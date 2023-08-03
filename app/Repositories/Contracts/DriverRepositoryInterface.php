<?php
namespace App\Repositories\Contracts;
use App\Models\{Driver, DriverProfile};
use Illuminate\Http\Request;
use App\DataTables\{DriverDataTable};
use App\DataTables\Trashed\DriverTrashedDataTable;
use App\Http\Requests\Dashboard\DriverValidationRequest;

interface DriverRepositoryInterface {
    public function index(DriverDataTable $driverDataTable);
    public function drivers_trashed(DriverTrashedDataTable $driverTrashedDataTable);
    public function create();
    public function store(DriverValidationRequest $request);
    public function show(string $id);
    public function updateStatus(Request $request, Driver $driver);
    public function updateApprovalTripStatus(Request $request, Driver $driver);
    public function update(Request $request, $id);
    public function destroy(Request $request, $id);
    public function forceDelete(Request $request, $id);
    public function restore(Request $request, $id);
    public function getMaps();
    public function updateProfile(Request $request, $id);
}