<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class StateDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new State());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('dashboard.states.btn.actions', compact('row'));
            })

            ->editColumn('status', function (State $state) {
                return $this->StatusChange($state->status,$state->status());
            })
            ->editColumn('countryName', function (State $state) {
                return $state->country->name ?? null;
            })

            ->rawColumns(['action','created_at', 'updated_at', 'countryName', 'status']);


    }

    public function query(): QueryBuilder{

        return State::with(['cities','country']);
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'country','data'=>'countryName','title'=> 'country','searchable'=>false,'orderable'=>false,],
            ['name'=>'status','data'=> 'status','title'=> 'Status','searchable'=>false,'orderable'=>false,],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}
