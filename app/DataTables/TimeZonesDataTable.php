<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\TimeZones;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class TimeZonesDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new TimeZones());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('dashboard.timeZones.btn.actions', compact('row'));
            })

            ->editColumn('status', function (TimeZones $timeZones) {
                return $this->StatusChange($timeZones->active,$timeZones->status());
            })



            ->rawColumns(['action', 'status']);


    }

    public function query(): QueryBuilder{

        return TimeZones::query();
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'timezone','data'=> 'timezone','title'=> 'timezone',],
            ['name'=>'status','data'=> 'status','title'=> 'Status',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}
