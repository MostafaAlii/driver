<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\ServiceLocations;
use App\Models\VehicleTypes;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class VehicleTypesDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new VehicleTypes());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $serviceLocations = ServiceLocations::all();
                return view('dashboard.vehicleType.btn.actions', compact('row', 'serviceLocations'));
            })
            ->editColumn('status', function (VehicleTypes $vehicleTypes) {
                return $this->StatusChange($vehicleTypes->status, $vehicleTypes->status());
            })
            ->editColumn('is_accept_share_ride', function (VehicleTypes $vehicleTypes) {
                return $this->StatusChange($vehicleTypes->is_accept_share_ride, $vehicleTypes->is_accept_share_ride());
            })
            ->rawColumns(['action', 'status', 'is_accept_share_ride']);


    }

    public function query(): QueryBuilder
    {

        return VehicleTypes::with(['service_location']);
    }

    protected function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'service_location', 'data' => 'service_location.name', 'title' => 'Service Location',],
            ['name' => 'is_accept_share_ride', 'data' => 'is_accept_share_ride', 'title' => 'is_accept Share Ride',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'action', 'data' => 'action', 'title' => 'Actions', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false,],
        ];
    }
}
