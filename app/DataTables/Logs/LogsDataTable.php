<?php
namespace App\DataTables\Logs;
use App\Models\History;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class LogsDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new History());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->editColumn('admins', function ($history) {
                return $this->linkWithCheckIcon('admins.show', $history->admin?->profile->uuid, $history->admin?->name);
            })
            ->editColumn('users', function ($history) {
                return $this->linkWithCheckIcon('users.show', $history->user?->profile->uuid, $history->user?->name);
            })
            ->editColumn('drivers', function ($history) {
                return $this->linkWithCheckIcon('drivers.show', $history->driver?->profile->uuid, $history->driver?->name);
            })
            ->editColumn('historyable_type', function ($history) {
                return $this->getDisplayModelName($history->historyable_type);
            })
            ->editColumn('created_at', function ($history) {
                return $history->created_at->diffForHumans();
            })
            ->editColumn('updated_at', function ($history) {
                return $history->updated_at->diffForHumans();
            })
            ->rawColumns(['admins', 'users', 'drivers', 'created_at', 'updated_at', 'historyable_type']);
    }

    public function query(): QueryBuilder{
        return History::with([
            'admin',
            'user',
            'driver',
        ]);
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'historyable_id','data'=>'historyable_id','title'=> 'Historyable Id',],
            ['name'=>'historyable_type','data'=> 'historyable_type','title'=> 'Historyable Type',],
            ['name'=>'changed_column','data'=> 'changed_column','title'=>'Changed Column',],
            ['name'=>'change_value_from','data'=> 'change_value_from','title'=>'Change Value From',],
            ['name'=>'change_value_to','data'=> 'change_value_to','title'=>'Change Value To',],
            ['name'=>'admin_id','data'=> 'admins','title'=>'Admin',],
            ['name'=>'user_id','data'=> 'users','title'=>'User',],
            ['name'=>'driver_id','data'=> 'drivers','title'=>'Driver',],
            ['name'=>'created_at','data'=> 'created_at','title'=>'Created At',],
            ['name'=>'updated_at','data'=> 'updated_at','title'=>'Updated At',],
        ];
    }

    private function linkWithCheckIcon($routeName, $profileUuid, $name) {
        $link = '<i class="fa fa-times-circle text-danger"></i>';
        if($name)
            $link = '<a href="' . route($routeName, $profileUuid) . '">' . $name . ' <i class="fa fa-check-circle text-success"></i> ' . '</a>';
        return $link;
    }

    private function getDisplayModelName($model) {
        return strtolower(class_basename($model)) . 's';
    }
}