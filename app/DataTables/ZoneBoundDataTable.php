<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\ZoneBound;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ZoneBoundDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new ZoneBound());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query));


    }

    public function query(): QueryBuilder
    {

        return ZoneBound::with(['zone']);
    }

    protected function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'zone', 'data' => 'zone.name', 'title' => 'zone',],
            ['name' => 'north', 'data' => 'north', 'title' => 'north',],
            ['name' => 'east', 'data' => 'east', 'title' => 'east',],
            ['name' => 'south', 'data' => 'south', 'title' => 'south',],
            ['name' => 'west', 'data' => 'west', 'title' => 'west',],
        ];
    }
}
