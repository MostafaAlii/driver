<?php
namespace  App\Repositories\Contracts;

use App\DataTables\Logs\LogsDataTable;
interface LogRepositoryInterface {
    public function index(LogsDataTable $logDataTable);
}