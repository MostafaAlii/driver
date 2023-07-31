<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\Country;
use App\Models\ServiceLocations;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ServiceLocationsDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new ServiceLocations());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $countries = Country::whereStatus(true)->get();
                return view('dashboard.serviceLocations.btn.actions', compact('row','countries'));
            })


            ->rawColumns(['action']);


    }

    public function query(): QueryBuilder{

        return ServiceLocations::with('country');
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name','orderable'=>false,'searchable'=>false,],
            ['name'=>'currencyName','data'=> 'currency_name','title'=> 'currencyName','orderable'=>false,'searchable'=>false,],
            ['name'=>'currencyCode','data'=> 'currency_code','title'=> 'currencyCode','orderable'=>false,'searchable'=>false,],
            ['name'=>'timezone','data'=> 'timezone','title'=> 'timezone','orderable'=>false,'searchable'=>false,],
            ['name'=>'country','data'=> 'country.name','title'=> 'country','orderable'=>false,'searchable'=>false,],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}
