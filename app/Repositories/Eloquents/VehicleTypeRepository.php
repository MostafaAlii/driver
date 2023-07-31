<?php

namespace App\Repositories\Eloquents;

use App\DataTables\VehicleTypesDataTable;
use App\Http\Requests\Dashboard\VehicleTypesRequest;
use App\Models\ServiceLocations;
use App\Models\VehicleTypes;
use App\Repositories\Contracts\VehicleTypeRepositoryInterface;


class VehicleTypeRepository implements VehicleTypeRepositoryInterface
{

    public function index(VehicleTypesDataTable $vehicleTypesDataTable)
    {
        return $vehicleTypesDataTable->render('dashboard.vehicleType.index', ['title' => 'vehicleType','serviceLocations' => ServiceLocations::all()]);

    }

    public function store(VehicleTypesRequest $request)
    {
        try {
            VehicleTypes::create($request->validated());
            $notification = array(
                'message' => 'vehicleType created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('vehicleType.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function update(VehicleTypesRequest $request)
    {
        try {
            VehicleTypes::findorfail($request->id)->update($request->validated());
            $notification = array(
                'message' => 'vehicleType created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('vehicleType.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            VehicleTypes::destroy($request->id);
            $notification = array(
                'message' => 'vehicleType Deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('vehicleType.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }


}
