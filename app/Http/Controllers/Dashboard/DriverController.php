<?php
namespace App\Http\Controllers\Dashboard;
use App\Models\{Driver, DriverProfile};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DriverValidationRequest;
use App\Repositories\Contracts\DriverRepositoryInterface;
use App\DataTables\{DriverDataTable, Trashed\DriverTrashedDataTable};

class DriverController extends Controller implements DriverRepositoryInterface {
    public function __construct(
        protected DriverDataTable $driverDataTable,
        protected DriverTrashedDataTable $driverTrashedDataTable,
        protected DriverRepositoryInterface $driverInterface) {
        $this->driverDataTable = $driverDataTable;
        $this->driverInterface = $driverInterface;
        $this->driverTrashedDataTable = $driverTrashedDataTable;
    }

    public function index(DriverDataTable $driverDataTable) {
        return $this->driverInterface->index($driverDataTable);
    }

    public function drivers_trashed(DriverTrashedDataTable $driverTrashedDataTable) { 
        return $this->driverInterface->drivers_trashed($driverTrashedDataTable);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return $this->driverInterface->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverValidationRequest $request) {
        return $this->driverInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        return $this->driverInterface->show($id);
    }

    public function updateStatus(Request $request, Driver $driver) {
        return $this->driverInterface->updateStatus($request, $driver);
    }

    public function updateApprovalTripStatus(Request $request, Driver $driver) {
        return $this->driverInterface->updateApprovalTripStatus($request, $driver);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        return $this->driverInterface->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id) {
        return $this->driverInterface->destroy($request, $id);
    }

    public function restore(Request $request, $id) {
        return $this->driverInterface->restore($request, $id);
    }

    public function forceDelete(Request $request, $id) {
        return $this->driverInterface->forceDelete($request, $id);
    }

    public function getMaps() {
        return $this->driverInterface->getMaps();
    }

    public function updateProfile(Request $request, $id) {
        return $this->driverInterface->updateProfile($request, $id);
    }
}
