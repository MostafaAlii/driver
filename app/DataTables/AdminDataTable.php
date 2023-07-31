<?php

namespace App\DataTables;

use App\Models\Admin;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class AdminDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new Admin());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Admin $admin) {
                return view('dashboard.admins.btn.actions', compact('admin'));
            })
            ->addColumn('checkbox', function (Admin $admin) {
                return view('dashboard.admins.btn.checkbox', compact('admin'));
            })
            ->addColumn('image', function (Admin $admin) {
                $image = $admin->getFirstMediaUrl(Admin::COLLECTION_NAME);
                return '<a href="' . route('admins.show', $admin->profile->uuid) . '">'
                    . (!empty($image)
                        ? '<img src="' . $image . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">'
                        : '<img src="' . asset('dashboard/default/default_admin.jpg') . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">')
                    . '</a>';
            })
            ->editColumn('created_at', function (Admin $admin) {
                return $this->formatBadge($this->formatDate($admin->created_at));
            })
            ->editColumn('updated_at', function (Admin $admin) {
                return $this->formatBadge($this->formatDate($admin->updated_at));
            })
            ->editColumn('name', function (Admin $admin) {
                return '<a href="' . route('admins.show', $admin->profile->uuid) . '">' . $admin->name . '</a>';
            })
            ->editColumn('type', function (Admin $admin) {
                return $this->formatType($admin->type);
            })
            ->editColumn('status', function (Admin $admin) {
                return $this->formatStatus($admin->status);
            })
            ->rawColumns(['action', 'checkbox', 'created_at', 'updated_at', 'name', 'type', 'status', 'image']);
    }

    public function query(): QueryBuilder {
        return checkTypeAdmin();
    }

    protected function getParameters() {
        $parameters = parent::getParameters();
        $parameters['buttons'][] = [
            [
                'text' => '<i class="fa fa-trash"></i> Multiple Delete',
                'className' => 'btn btn-danger delBtn',
            ],
        ];
        return $parameters;
    }

    protected function getColumns(): array {
        return [
            ['name' => 'checkbox', 'data' => 'checkbox', 'title' => '<input type="checkbox" class="check_all" onclick="check_all()" />', 'orderable' => false, 'searchable' => false,],
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'image', 'data' => 'image', 'title' => 'Image', 'orderable' => false, 'searchable' => false,],
            ['name' => 'name', 'data' => 'name', 'title' => 'Name',],
            ['name' => 'email', 'data' => 'email', 'title' => 'Email',],
            ['name' => 'country', 'data' => 'country.name', 'title' => 'country', 'orderable' => false, 'searchable' => false,],
            ['name' => 'type', 'data' => 'type', 'title' => 'Type',],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status',],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => 'Created_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => 'Update_at', 'orderable' => false, 'searchable' => false,],
            ['name' => 'action', 'data' => 'action', 'title' => 'Actions', 'exportable' => false, 'printable' => false, 'orderable' => false, 'searchable' => false,],
        ];
    }
}
