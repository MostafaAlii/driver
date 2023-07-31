<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CityDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(protected CityDataTable $cityDataTable, protected CityRepositoryInterface $cityInterface)
    {
        $this->cityDataTable = $cityDataTable;
        $this->cityInterface = $cityInterface;
    }

    public function index(CityDataTable $cityDataTable)
    {
        return $this->cityInterface->index($cityDataTable);
    }

    public function changeStatusCity(Request $request)
    {
        return $this->cityInterface->changeStatusCity($request);
    }
}
