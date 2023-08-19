<?php
namespace  App\Repositories\Contracts;
use App\DataTables\CarTypeDataTable;
use Illuminate\Http\Request;

interface CarTypeRepositoryInterface {
    public function index(CarTypeDataTable $carTypeDataTable);
}
