<?php

namespace App\Repositories\Eloquents;

use App\DataTables\ZoneDataTable;
use App\Http\Requests\ZoneRequest;
use App\Models\Zone;
use App\Repositories\Contracts\ZoneRepositoryInterface;
use Illuminate\Http\Request;

class ZoneRepository implements ZoneRepositoryInterface
{
    public function index(ZoneDataTable $zoneDataTable)
    {
        return $zoneDataTable->render('dashboard.zone.index',['title' =>  'zone']);
    }

    public function store(ZoneRequest $request)
    {
        try {
            Zone::create($request->validated());
            $notification = array(
                'message' => 'zone created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('zone.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function update(Request $request)
    {

        try {
            Zone::findorfail($request->id)->update([
                'status' => $request->status,
            ]);
            $notification = array(
                'message' => 'zone Updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('zone.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy($request)
    {
        try {
            Zone::destroy($request->id);
            $notification = array(
                'message' => 'zone Deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('zone.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }
}
