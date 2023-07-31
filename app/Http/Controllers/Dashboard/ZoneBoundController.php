<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ZoneBoundDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ZoneBoundRepositoryInterface;
use Illuminate\Http\Request;

class ZoneBoundController extends Controller
{
    public function __construct(protected ZoneBoundDataTable $zoneBoundDataTable, protected ZoneBoundRepositoryInterface $zoneBoundInterface) {
        $this->zoneBoundDataTable = $zoneBoundDataTable;
        $this->zoneBoundInterface = $zoneBoundInterface;
    }

    public function index(ZoneBoundDataTable $zoneBoundDataTable)
    {
        return $this->zoneBoundInterface->index($zoneBoundDataTable);
    }

}
