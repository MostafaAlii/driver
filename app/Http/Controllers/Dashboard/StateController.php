<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\StateDataTable;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\StateRepositoryInterface;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function __construct(protected StateDataTable $stateDataTable, protected StateRepositoryInterface $stateInterface)
    {
        $this->stateDataTable = $stateDataTable;
        $this->stateInterface = $stateInterface;
    }

    public function index(StateDataTable $stateDataTable)
    {
        return $this->stateInterface->index($stateDataTable);
    }

    public function changeStatusState(Request $request)
    {
        return $this->stateInterface->changeStatusState($request);
    }
}
