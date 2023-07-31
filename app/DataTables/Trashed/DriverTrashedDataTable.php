<?php
namespace App\DataTables\Trashed;
use App\Models\Driver;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class DriverTrashedDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new Driver());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Driver $driver) {
                return view('dashboard.drivers.btn.trashed_actions', compact('driver'));
            })
            ->addColumn('image', function (Driver $driver) {
                $image = $driver->getFirstMediaUrl(Driver::COLLECTION_NAME);
                return '<a href="#">'
                    . (!empty($image)
                        ? '<img src="' . $image . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">'
                        : '<img src="' . asset('dashboard/default/default_admin.jpg') . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">')
                    . '</a>';
            })
            ->editColumn('created_at', function (Driver $driver) {
                return $this->formatBadge($this->formatDate($driver->created_at));
            })
            ->editColumn('updated_at', function (Driver $driver) {
                return $this->formatBadge($this->formatDate($driver->updated_at));
            })
            ->editColumn('status', function (Driver $driver) {
                return $this->formatStatus($driver->status);
            })
            
            ->rawColumns(['action','created_at', 'updated_at', 'status', 'image']);
        
            
    }

    public function query(): QueryBuilder{
        return Driver::with(['media'])->onlyTrashed()->latest()->select('id', 'name', 'email', 'deleted_at');  
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'image','data'=>'image','title'=>'Image','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'email','data'=> 'email','title'=> 'Email',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}
