<?php
namespace App\DataTables;
use App\Models\User;
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class UserTrashedDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new User());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (User $user) {
                return view('dashboard.users.btn.trashed_actions', compact('user'));
            })
            ->addColumn('checkbox', function (User $user) {
                return view('dashboard.users.btn.checkbox', compact('user'));
            })
            ->addColumn('image', function (User $user) {
                $image = $user->getFirstMediaUrl(User::COLLECTION_NAME);
                return '<a href="#">'
                    . (!empty($image)
                        ? '<img src="' . $image . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">'
                        : '<img src="' . asset('dashboard/default/default_admin.jpg') . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">')
                    . '</a>';
            })
            ->editColumn('created_at', function (User $user) {
                return $this->formatBadge($this->formatDate($user->created_at));
            })
            ->editColumn('updated_at', function (User $user) {
                return $this->formatBadge($this->formatDate($user->updated_at));
            })
            ->editColumn('status', function (User $user) {
                return $this->formatStatus($user->status);
            })
            
            ->rawColumns(['checkbox', 'action','created_at', 'updated_at', 'status', 'image']);
        
            
    }

    public function query(): QueryBuilder{
        return User::with(['media'])->onlyTrashed()->latest()->select('id', 'name', 'email', 'deleted_at');  
    }

    protected function getColumns(): array {
        return [
            ['name' => 'checkbox', 'data' => 'checkbox', 'title' => '<input type="checkbox" class="check_all" onclick="check_all()" />', 'orderable' => false, 'searchable' => false,],
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'image','data'=>'image','title'=>'Image','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'email','data'=> 'email','title'=> 'Email',],
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