<?php
namespace  App\Repositories\Contracts;
use App\DataTables\ZoneDataTable;
use App\Http\Requests\ZoneRequest;
use Illuminate\Http\Request;

interface ZoneRepositoryInterface {
    public function index(ZoneDataTable $zoneDataTable);
    public function store(ZoneRequest $request);
    public function update(Request $request);
    public function destroy($request);
}
