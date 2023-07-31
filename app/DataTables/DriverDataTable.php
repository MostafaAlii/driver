<?php
namespace App\DataTables;
use Carbon\Carbon;
use App\Models\Driver;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class DriverDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new Driver());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Driver $driver) {
                return view('dashboard.drivers.btn.actions', compact('driver'));
            })
            
            ->editColumn('created_at', function (Driver $driver) {
                return $this->formatBadge($this->formatDate($driver->created_at));
            })
            ->editColumn('email_verified_at', function (Driver $driver) {
                if(!empty($driver->email_verified_at))
                    return '<span class="badge badge-info">' . Carbon::parse($driver->email_verified_at)->format('Y-m-d H:i:s')  . '</span>';
                return '<span class="badge badge-danger">Not Verified</span>';
            })
            ->editColumn('updated_at', function (Driver $driver) {
                return $this->formatBadge($this->formatDate($driver->updated_at));
            })
            ->editColumn('name', function (Driver $driver) {
                return '<a href="'.route('drivers.show', $driver->profile->uuid).'">'.$driver->name.'</a>';
            })
            ->editColumn('gender', function (Driver $driver) {
                $iconClass = ($driver->gender === 'male') ? 'fa fa-male text-light ' : 'fa fa-female text-light';
                $backgroundClass = ($driver->gender === 'male') ? 'bg-dark' : 'bg-warning';
                return '<div style="font-size: 25px; display: inline-block; border-radius: 50%; padding: 5px;" class="' . $backgroundClass . '"><i class="' . $iconClass . '"></i></div>';
            })
            ->editColumn('avatar', function (Driver $driver) {
                if (empty($driver->profile->avatar))
                    return '<img src="' . asset('dashboard/default/default_admin.jpg') . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;" />';
                return '<img src="' . asset('dashboard/images/driver_document/' . $driver->email . $driver->phone . '_' . $driver->profile->uuid  . '/' . $driver->profile->avatar) . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;" />';
            })
            
            ->editColumn('status', function (Driver $driver) {
                return $this->StatusChangeDrivers($driver->status);
            })
            ->addColumn('trip_approval', function (Driver $driver) {
                return $this->TripApproveChangeDrivers($driver->profile->status);

            })
            ->rawColumns(['trip_approval','action','created_at', 'avatar', 'updated_at', 'name', 'status', 'gender', 'email_verified_at']);    
    }

    public function query(): QueryBuilder{
        if(get_user_data()->type == 'general')
            return Driver::with(['profile','driverDetails', 'country'])->orderBy('id', 'ASC');
        return Driver::with(['profile','driverDetails', 'country'])->whereCountryId(get_user_data()->country_id)->orderBy('id', 'ASC');
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'avatar','data'=>'avatar','title'=> 'Avatar', 'orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'phone','data'=>'phone','title'=> 'Phone',],
            ['name' => 'country', 'data' => 'country.name', 'title' => 'country', 'orderable' => false, 'searchable' => false,],
            ['name'=>'status','data'=> 'status','title'=> 'Status',],
            ['name'=>'trip_approval','data'=> 'trip_approval','title'=> 'Trip Approve',],
            ['name'=>'gender','data'=> 'gender','title'=> 'Gender',],
            ['name'=>'email_verified_at','data'=> 'email_verified_at','title'=>'Verified At',],
            ['name'=>'created_at','data'=> 'created_at','title'=>'Created_at',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}
