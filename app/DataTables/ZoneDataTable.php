<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ZoneDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new Zone());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {

                return view('dashboard.zone.btn.actions', compact('row'));
            })
            ->editColumn('status', function (Zone $zone) {
                return $this->StatusChange($zone->status, $zone->status());
            })

            ->rawColumns([ 'status']);


    }

    public function query(): QueryBuilder
    {

        return Zone::with(['service_location']);
    }

    protected function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'service_location', 'data' => 'service_location.name', 'title' => 'Service Location',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'action', 'data' => 'action', 'title' => 'Actions', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false,],
        ];
    }
}
