<?php
namespace  App\Repositories\Eloquents;
use App\Models\History;
use Illuminate\Http\Request;
use App\DataTables\Logs\LogsDataTable;
use App\Repositories\Contracts\LogRepositoryInterface;

class LogRepository implements LogRepositoryInterface {
    public function __construct(protected LogsDataTable $logDataTable) {
        $this->logDataTable = $logDataTable;
    }
    
    public function index(LogsDataTable $logDataTable) {
        return $logDataTable->render('dashboard.logs.index',['title' => 'Logs']);
    }
}