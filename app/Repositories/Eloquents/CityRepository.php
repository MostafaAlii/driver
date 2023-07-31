<?php

namespace App\Repositories\Eloquents;

use App\DataTables\CityDataTable;
use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityRepository implements CityRepositoryInterface
{

    public function index(CityDataTable $cityDataTable)
    {
        return $cityDataTable->render('dashboard.cities.index', ['title' => 'cities']);
    }

    public function changeStatusCity(Request $request)
    {
        City::findorfail($request->id)->update([
            'status' => $request->status,
        ]);

        $notification = array(
            'message' =>  'countries Change City successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('cities.index')->with($notification);
    }
}
