<?php

namespace App\Repositories\Eloquents;

use App\DataTables\TimeZonesDataTable;
use App\Http\Requests\Dashboard\ServiceLocationsRequest;
use App\Http\Requests\Dashboard\TimeZonesRequest;
use App\Models\TimeZones;
use App\Repositories\Contracts\TimeZoneRepositoryInterface;
use Illuminate\Http\Request;

class TimeZoneRepository implements TimeZoneRepositoryInterface
{

    public function index(TimeZonesDataTable $timeZonesDataTable)
    {
        return $timeZonesDataTable->render('dashboard.timeZones.index', ['title' => 'timeZones']);
    }

    public function store(TimeZonesRequest $request)
    {
        try {
            TimeZones::create($request->validated());
            $notification = array(
                'message' => 'timeZones created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('timeZones.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function update(TimeZonesRequest $request)
    {
        try {
            TimeZones::findorfail($request->id)->update($request->validated());
            $notification = array(
                'message' => 'timeZones Updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('timeZones.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            TimeZones::destroy($request->id);
            $notification = array(
                'message' => 'timeZones Deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('timeZones.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
