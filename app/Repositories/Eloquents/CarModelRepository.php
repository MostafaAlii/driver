<?php

namespace App\Repositories\Eloquents;

use App\DataTables\CarMakeDataTable;
use App\DataTables\CarModelDataTable;
use App\Models\CarModel;
use App\Repositories\Contracts\CarModelRepositoryInterface;
use Illuminate\Http\Request;

class CarModelRepository implements CarModelRepositoryInterface
{


    public function index(CarModelDataTable $carModelDataTable)
    {
        return $carModelDataTable->render('dashboard.carModel.index', ['title' => 'carModel']);
    }

    public function changeStatusCarModel(Request $request)
    {
        CarModel::findorfail($request->id)->update([
            'status' => $request->status
        ]);

        $notification = array(
            'message' => 'CarModel Change successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('carModel.index')->with($notification);
    }
}
