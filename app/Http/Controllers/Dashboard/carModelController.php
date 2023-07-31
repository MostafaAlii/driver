<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\CarMakeDataTable;
use App\DataTables\CarModelDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CarMakeRepositoryInterface;
use App\Repositories\Contracts\CarModelRepositoryInterface;
use Illuminate\Http\Request;

class carModelController extends Controller
{
    public function __construct(protected CarModelDataTable $carModelDataTable, protected CarModelRepositoryInterface $carModelInterface)
    {
        $this->carModelDataTable = $carModelDataTable;
        $this->carModelInterface = $carModelInterface;
    }

    public function index(CarModelDataTable $carModelDataTable)
    {
        return $this->carModelInterface->index($carModelDataTable);
    }

    public function changeStatusCarModel(Request $request)
    {
        return $this->carModelInterface->changeStatusCarModel($request);

    }
}
