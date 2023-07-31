<?php

namespace App\Http\Controllers\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Logs\LogsDataTable;
use App\Repositories\Contracts\LogRepositoryInterface;

class LogsController extends Controller {
    public function __construct(protected LogsDataTable $logDataTable, protected LogRepositoryInterface $logsInterface) {
        $this->logDataTable = $logDataTable;
        $this->logsInterface = $logsInterface;
    }
    public function __invoke(LogsDataTable $logDataTable) {
        return $this->logsInterface->index($logDataTable);
    }
}
