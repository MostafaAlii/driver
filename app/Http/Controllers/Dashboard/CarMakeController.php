<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CarMakeDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CarMakeRepositoryInterface;
use Illuminate\Http\Request;

class CarMakeController extends Controller
{
    public function __construct(protected CarMakeDataTable $carMakeDataTable, protected CarMakeRepositoryInterface $carMakeInterface)
    {
        $this->carMakeDataTable = $carMakeDataTable;
        $this->carMakeInterface = $carMakeInterface;
    }

    public function index(CarMakeDataTable $carMakeDataTable)
    {
        return $this->carMakeInterface->index($carMakeDataTable);
    }

    public function changeStatusCarMake(Request $request)
    {
        return $this->carMakeInterface->changeStatusCarMake($request);
    }
}
