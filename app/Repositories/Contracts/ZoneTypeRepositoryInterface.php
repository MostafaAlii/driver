<?php
namespace  App\Repositories\Contracts;
use App\DataTables\ZoneTypesDataTable;
use Illuminate\Http\Request;

interface ZoneTypeRepositoryInterface {
    public function index(ZoneTypesDataTable $zoneTypesDataTable);
    public function store($request);
    public function update(Request $request);
    public function destroy($request);
}
