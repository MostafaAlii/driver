<?php
namespace  App\Repositories\Contracts;
use App\DataTables\CarMakeDataTable;
use Illuminate\Http\Request;

interface CarMakeRepositoryInterface {
    public function index(CarMakeDataTable $carMakeDataTable);

    public function changeStatusCarMake(Request $request);
}
