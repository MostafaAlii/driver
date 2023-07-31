<?php
namespace  App\Repositories\Contracts;
use App\DataTables\VehicleTypesDataTable;
use App\Http\Requests\Dashboard\VehicleTypesRequest;

interface VehicleTypeRepositoryInterface {
    public function index(VehicleTypesDataTable $vehicleTypesDataTable);
    public function store(VehicleTypesRequest $request);
    public function update(VehicleTypesRequest $request);
    public function destroy($request);
}
