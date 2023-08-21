<?php
namespace App\DataTables;
use App\Models\User;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;
use Carbon\Carbon;
class UserDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new User());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (User $user) {
                return view('dashboard.users.btn.actions', compact('user'));
            })
            ->addColumn('checkbox', function (User $user) {
                return view('dashboard.users.btn.checkbox', compact('user'));
            })
            
            ->editColumn('created_at', function (User $user) {
                return $this->formatBadge($this->formatDate($user->created_at));
            })
            ->editColumn('email_verified_at', function (User $user) {
                if(!empty($user->email_verified_at))
                    return '<span class="badge badge-info">' . Carbon::parse($user->email_verified_at)->format('Y-m-d H:i:s')  . '</span>';
                return '<span class="badge badge-danger">Not Verified</span>';
            })
            ->editColumn('updated_at', function (User $user) {
                return $this->formatBadge($this->formatDate($user->updated_at));
            })
            ->editColumn('name', function (User $user) {
                return '<a href="'.route('users.show', $user->profile->uuid).'">'.$user->name.'</a>';
            })
            ->editColumn('status', function (User $user) {
                return $this->formatStatus($user->status);
            })
            
            ->rawColumns(['checkbox', 'action','created_at', 'updated_at', 'name', 'status', 'email_verified_at']);
        
            
    }

    public function query(): QueryBuilder{
        if(get_user_data()->type == 'general')
            return User::with(['profile', 'country'])->orderBy('id', 'ASC');
        return User::with(['profile', 'country'])->whereCountryId(get_user_data()->country_id)->orderBy('id', 'ASC');
    }

    protected function getColumns(): array {
        return [
            ['name' => 'checkbox', 'data' => 'checkbox', 'title' => '<input type="checkbox" class="check_all" onclick="check_all()" />', 'orderable' => false, 'searchable' => false,],
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'phone','data'=>'phone','title'=> 'Phone',],
            ['name'=>'email','data'=> 'email','title'=> 'Email',],
            ['name' => 'country', 'data' => 'country.name', 'title' => 'country', 'orderable' => false, 'searchable' => false,],
            ['name'=>'status','data'=> 'status','title'=> 'Status',],
            ['name'=>'email_verified_at','data'=> 'email_verified_at','title'=>'Verified',],
            ['name'=>'created_at','data'=> 'created_at','title'=>'Created_at',],
            ['name'=>'updated_at','data'=> 'updated_at','title'=>'Update_at',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
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
}
