<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ZoneDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ZoneRequest;
use App\Repositories\Contracts\ZoneRepositoryInterface;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function __construct(protected ZoneDataTable $zoneDataTable, protected ZoneRepositoryInterface $zoneInterface)
    {
        $this->zoneDataTable = $zoneDataTable;
        $this->zoneInterface = $zoneInterface;
    }

    public function index(ZoneDataTable $zoneDataTable)
    {
        return $this->zoneInterface->index($zoneDataTable);
    }


    public function store(ZoneRequest $request)
    {
        return $this->zoneInterface->store($request);
    }


    public function update(Request $request)
    {
        return $this->zoneInterface->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->zoneInterface->destroy($request);
    }
}
