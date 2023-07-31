<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CountryDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(protected CountryDataTable $countryDataTable, protected CountryRepositoryInterface $countryInterface)
    {
        $this->countryDataTable = $countryDataTable;
        $this->countryInterface = $countryInterface;
    }

    public function index(CountryDataTable $countryDataTable)
    {
        return $this->countryInterface->index($countryDataTable);
    }

    public function changeStatusCountry(Request $request)
    {
        return $this->countryInterface->changeStatusCountry($request);
    }
}
