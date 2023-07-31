<?php

namespace App\Repositories\Eloquents;

use App\DataTables\CountryDataTable;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Http\Request;

class CountryRepository implements CountryRepositoryInterface
{

    public function index(CountryDataTable $countryDataTable)
    {
        return $countryDataTable->render('dashboard.countries.index', ['title' => 'countries']);
    }

    public function changeStatusCountry(Request $request)
    {
        Country::findOrFail($request->id)->update([
            'status' => $request->status,
        ]);

        State::where('country_id', $request->id)->update([
            'status' => $request->status,
        ]);

        City::whereHas('state', function ($query) use ($request) {
            $query->where('country_id', $request->id);
        })->update([
            'status' => $request->status,
        ]);

        $notification = array(
            'message' =>  'countries Change Status successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('countries.index')->with($notification);

    }
}
