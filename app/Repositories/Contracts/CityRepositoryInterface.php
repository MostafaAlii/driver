<?php
namespace  App\Repositories\Contracts;
use App\DataTables\CityDataTable;
use Illuminate\Http\Request;

interface CityRepositoryInterface {
    public function index(CityDataTable $cityDataTable);

    public function changeStatusCity(Request $request);
}
