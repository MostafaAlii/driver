<?php
namespace  App\Repositories\Contracts;
use App\DataTables\CarMakeDataTable;
use App\DataTables\CarModelDataTable;
use Illuminate\Http\Request;

interface CarModelRepositoryInterface {
    public function index(CarModelDataTable $carMakeDataTable);

    public function changeStatusCarModel(Request $request);
}
