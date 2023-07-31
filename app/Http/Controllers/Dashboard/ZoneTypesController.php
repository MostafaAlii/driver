<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ZoneTypesDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ZoneBoundRepositoryInterface;
use App\Repositories\Contracts\ZoneTypeRepositoryInterface;
use Illuminate\Http\Request;

class ZoneTypesController extends Controller
{
    public function __construct(protected ZoneTypesDataTable $zoneTypesDataTable, protected ZoneTypeRepositoryInterface $zoneTypeInterface) {
        $this->zoneTypesDataTable = $zoneTypesDataTable;
        $this->zoneTypeInterface = $zoneTypeInterface;
    }

    public function index(ZoneTypesDataTable $zoneTypesDataTable)
    {
        return $this->zoneTypeInterface->index($zoneTypesDataTable);
    }

    public function update(Request $request)
    {
        return $this->zoneTypeInterface->update($request);
    }
}
