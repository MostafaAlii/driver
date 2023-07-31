<?php

namespace App\DataTables;

use App\DataTables\Base\BaseDataTable;
use App\Models\SettingOtp;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SettingOtpDataTable extends BaseDataTable
{
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new SettingOtp());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function (SettingOtp $settingOtp) {
                return $this->StatusChange($settingOtp->verified, $settingOtp->status());
            })

            ->editColumn('updated_at', function (SettingOtp $settingOtp) {
                return $this->formatBadge($this->formatDate($settingOtp->updated_at));
            })

            ->rawColumns(['status','updated_at']);


    }

    public function query(): QueryBuilder
    {

        return SettingOtp::query()->orderByDesc('id');
    }

    protected function getColumns(): array
    {
        return [
            ['name' => 'id', 'data' => 'id', 'title' => '#', 'orderable' => false, 'searchable' => false,],
            ['name' => 'phone', 'data' => 'phone', 'title' => 'Phone', 'orderable' => false, 'searchable' => false,],
            ['name' => 'Otp', 'data' => 'otp', 'title' => 'otp', 'orderable' => false, 'searchable' => false,],
            ['name' => 'Type', 'data' => 'Usertype_type', 'title' => 'Type', 'orderable' => false, 'searchable' => false,],
            ['name' => 'status', 'data' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false,],
            ['name' => 'updatedDate', 'data' => 'updated_at', 'title' => 'updatedDate', 'orderable' => false, 'searchable' => false,],
        ];
    }
}
