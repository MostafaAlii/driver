<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\VehicleTypesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\VehicleTypesRequest;
use App\Repositories\Contracts\VehicleTypeRepositoryInterface;
use Illuminate\Http\Request;

class VehicleTypesController extends Controller
{
    public function __construct(protected VehicleTypesDataTable $vehicleTypesDataTable, protected VehicleTypeRepositoryInterface $vehicleTypeInterface) {
        $this->vehicleTypesDataTable = $vehicleTypesDataTable;
        $this->vehicleTypeInterface = $vehicleTypeInterface;
    }

    public function index(VehicleTypesDataTable $vehicleTypesDataTable)
    {
        return $this->vehicleTypeInterface->index($vehicleTypesDataTable);
    }


    public function store(VehicleTypesRequest $request)
    {
        return $this->vehicleTypeInterface->store($request);
    }


    public function update(VehicleTypesRequest $request, string $id)
    {
        return $this->vehicleTypeInterface->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->vehicleTypeInterface->destroy($request);
    }
}
