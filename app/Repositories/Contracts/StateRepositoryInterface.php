<?php
namespace  App\Repositories\Contracts;
use App\DataTables\StateDataTable;
use Illuminate\Http\Request;

interface StateRepositoryInterface {
    public function index(StateDataTable $stateDataTable);

    public function changeStatusState(Request $request);
}
