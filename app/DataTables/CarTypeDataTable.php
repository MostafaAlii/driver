<?php
namespace App\DataTables;
use App\DataTables\Base\BaseDataTable;
use App\Models\CarType;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
class CarTypeDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new CarType());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('dashboard.carType.btn.actions', compact('row'));
            })
            ->editColumn('status', function (CarType $CarType) {
                return $this->StatusChange($CarType->status,$CarType->status());
            })
            ->addColumn('carModel', function (CarType $CarType) {
                return '<span class="badge badge-info">'.$CarType->carModels->count().'</span>';
            })
            ->rawColumns(['action', 'status', 'carModel']);
    }

    public function query(): QueryBuilder{
        return CarType::query();
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'carModel','data'=>'carModel','title'=> 'Car Model','orderable'=>false,'searchable'=>false,],
            ['name'=>'status','data'=> 'status','title'=> 'Status',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }


}