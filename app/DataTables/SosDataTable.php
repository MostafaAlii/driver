<?php
namespace App\DataTables;
use App\Models\Sos;
use App\Models\ServiceLocations;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SosDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new Sos());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Sos $sos) {
                $servicesLocations = ServiceLocations::get();
                return view('dashboard.sos.btn.actions', compact('sos', 'servicesLocations'));
            })
            ->editColumn('created_at', function (Sos $sos) {
                return $this->formatBadge($this->formatDate($sos->created_at));
            })
            ->editColumn('updated_at', function (Sos $sos) {
                return $this->formatBadge($this->formatDate($sos->updated_at));
            })
            ->editColumn('status', function (Sos $sos) {
                return $this->formatStatus($sos->status);
            })->editColumn('service_location_id', function (Sos $sos) {
                return $sos->serviceLocation->name;
            })
            ->editColumn('admin_id', function (Sos $sos) {
                return '<a href="'.route('admins.show', $sos->admin->profile->uuid).'">'.$sos->admin->name.'</a>';
            })
            ->rawColumns(['action','created_at', 'updated_at','status', 'service_location_id', 'admin_id']);
        
            
    }

    public function query(): QueryBuilder{
        return Sos::with(['serviceLocation', 'admin','admin.profile'])->latest();
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'number','data'=>'number','title'=> 'Number',],
            ['name'=>'service_location_id','data'=>'service_location_id','title'=> 'Service Location', 'orderable'=>false,'searchable'=>false,],
            ['name'=>'admin_id','data'=>'admin_id','title'=> 'Admin', 'orderable'=>false,'searchable'=>false,],
            
            ['name'=>'status','data'=> 'status','title'=> 'Status' ,'orderable'=>false,'searchable'=>false,],
            ['name'=>'created_at','data'=> 'created_at','title'=>'Created_at',],
            ['name'=>'updated_at','data'=> 'updated_at','title'=>'Update_at',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}