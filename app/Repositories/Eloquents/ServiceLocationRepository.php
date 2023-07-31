<?php

namespace App\Repositories\Eloquents;

use App\DataTables\ServiceLocationsDataTable;
use App\Http\Requests\Dashboard\ServiceLocationsRequest;
use App\Models\Country;
use App\Models\ServiceLocations;
use App\Repositories\Contracts\ServiceLocationRepositoryInterface;
use Illuminate\Http\Request;

class ServiceLocationRepository implements ServiceLocationRepositoryInterface
{
    public function index(ServiceLocationsDataTable $locationsDataTable)
    {
        return $locationsDataTable->render('dashboard.serviceLocations.index', ['title' => 'ServiceLocations' ,'countries' => Country::whereStatus(true)->get()]);
    }

    public function store(ServiceLocationsRequest $request)
    {
        try {
            ServiceLocations::create($request->validated());
            $notification = array(
                'message' =>  'serviceLocation created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('serviceLocation.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function update(ServiceLocationsRequest $request)
    {
        try {
            ServiceLocations::findorfail($request->id)->update($request->validated());
            $notification = array(
                'message' =>  'serviceLocation Updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('serviceLocation.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            ServiceLocations::destroy($request->id);
            $notification = array(
                'message' =>  'serviceLocation Deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('serviceLocation.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }


}
