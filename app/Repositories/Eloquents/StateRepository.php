<?php

namespace App\Repositories\Eloquents;

use App\DataTables\StateDataTable;
use App\Models\City;
use App\Models\State;
use App\Repositories\Contracts\StateRepositoryInterface;
use Illuminate\Http\Request;

class StateRepository implements StateRepositoryInterface
{

    public function index(StateDataTable $stateDataTable)
    {
        return $stateDataTable->render('dashboard.states.index', ['title' => 'states']);
    }


    public function changeStatusState(Request $request)
    {
        State::findorfail($request->id)->update([
            'status' => $request->status,
        ]);

        City::where('state_id',$request->id)->update([
            'status' => $request->status,
        ]);

        $notification = array(
            'message' =>  'countries status Status successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('states.index')->with($notification);
    }
}
