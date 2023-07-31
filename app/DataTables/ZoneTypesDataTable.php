<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\ZoneTypes;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ZoneTypesDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new ZoneTypes());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function (ZoneTypes $zoneTypes) {
                return $this->StatusChange($zoneTypes->status,$zoneTypes->status());
            })
            ->addColumn('action', function ($row) {

                return view('dashboard.zoneTypes.btn.actions', compact('row'));
            })
            ->rawColumns(['status','action']);


    }

    public function query(): QueryBuilder
    {

        return ZoneTypes::with(['zone','vehicle_type']);
    }

    protected function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'zone', 'data' => 'zone.name', 'title' => 'zone',],
            ['name' => 'vehicle type', 'data' => 'vehicle_type.name', 'title' => 'vehicle type',],
            ['name' => 'bill status', 'data' => 'bill_status', 'title' => 'bill status',],
            ['name' => 'payment type', 'data' => 'payment_type', 'title' => 'payment type',],
            ['name' => 'status', 'data' => 'status', 'title' => 'status',],
            ['name' => 'action', 'data' => 'action', 'title' => 'Actions', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false,],

        ];
    }
}
