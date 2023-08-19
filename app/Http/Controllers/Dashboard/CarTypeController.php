<?php
namespace App\Http\Controllers\Dashboard;
use App\DataTables\CarTypeDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CarTypeRepositoryInterface;
use Illuminate\Http\Request;
class CarTypeController extends Controller {
    public function __construct(protected CarTypeDataTable $carTypeDataTable, protected CarTypeRepositoryInterface $carTypeInterface) {
        $this->carTypeDataTable = $carTypeDataTable;
        $this->carTypeInterface = $carTypeInterface;
    }

    public function index(CarTypeDataTable $carTypeDataTable) {
        return $this->carTypeInterface->index($carTypeDataTable);
    }
}