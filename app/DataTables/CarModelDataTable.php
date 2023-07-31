<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\CarModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class CarModelDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new CarModel());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('dashboard.carModel.btn.actions', compact('row'));
            })
            ->editColumn('status', function (CarModel $carModel) {
                return $this->StatusChange($carModel->status, $carModel->status());
            })
            ->editColumn('nameCarMake', function (CarModel $carModel) {
               return $carModel->car_make->name ?? null;
            })
            ->rawColumns(['action', 'status','nameCarMake']);


    }

    public function query(): QueryBuilder
    {

        return CarModel::with(['car_make']);
    }

    protected function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'nameCarMake', 'data' => 'nameCarMake', 'title' => 'nameCarMake',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'action', 'data' => 'action', 'title' => 'Actions', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false,],
        ];
    }
}
