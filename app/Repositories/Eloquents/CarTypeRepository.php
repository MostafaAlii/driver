<?php
namespace App\Repositories\Eloquents;
use App\DataTables\CarTypeDataTable;
use App\Models\CarType;
use App\Repositories\Contracts\CarTypeRepositoryInterface;
use Illuminate\Http\Request;
class CarTypeRepository implements CarTypeRepositoryInterface {
    public function index(CarTypeDataTable $carTypeDataTable) {
        return $carTypeDataTable->render('dashboard.carType.index', ['title' => 'Car Type']);
    }
}
