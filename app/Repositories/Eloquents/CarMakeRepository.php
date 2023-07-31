<?php

namespace App\Repositories\Eloquents;

use App\DataTables\CarMakeDataTable;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Repositories\Contracts\CarMakeRepositoryInterface;
use Illuminate\Http\Request;

class CarMakeRepository implements CarMakeRepositoryInterface
{

    public function index(CarMakeDataTable $carMakeDataTable)
    {
        return $carMakeDataTable->render('dashboard.carMake.index', ['title' => 'CarMake']);
    }

    public function changeStatusCarMake(Request $request)
    {

        CarMake::findorfail($request->id)->update([
            'status' => $request->status
        ]);

        CarModel::where('car_make_id', $request->id)->update([
            'status' => $request->status
        ]);

        $notification = array(
            'message' =>  'CarMake Change successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('carMake.index')->with($notification);
    }
}
