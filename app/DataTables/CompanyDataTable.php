<?php
namespace App\DataTables;
use App\Models\{Company, Country};
use App\DataTables\Base\BaseDataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class CompanyDataTable extends BaseDataTable {
    public function __construct(protected DataTableRequest $request, protected HtmlBuilder $htmlBuilder) {
        $this->htmlBuilder = $htmlBuilder;
        $this->request = $request;
        parent::__construct(new Company());
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Company $company) {
                $countries = Country::active()->get(['id', 'name']);
                return view('dashboard.company.btn.actions', compact('company', 'countries'));
            })
            ->addColumn('image', function (Company $company) {
                $image = $company->getFirstMediaUrl(Company::COLLECTION_NAME);
                return '<a href="'.route('company.show', $company->profile->uuid).'">'
                    . (!empty($image)
                        ? '<img src="' . $image . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">'
                        : '<img src="' . asset('dashboard/default/default_company.png') . '" class="img-fluid" style="width: 50px; height: 50px; border-radius: 50%;">')
                    . '</a>';
            })
            ->editColumn('created_at', function (Company $company) {
                return $this->formatBadge($this->formatDate($company->created_at));
            })
            ->editColumn('updated_at', function (Company $company) {
                return $this->formatBadge($this->formatDate($company->updated_at));
            })
            ->editColumn('name', function (Company $company) {
                return '<a href="'.route('company.show', $company->profile->uuid).'">'.$company->name.'</a>';
            })
            ->editColumn('status', function (Company $company) {
                return $company->status();
            })
            
            ->rawColumns(['action','created_at', 'updated_at', 'name','status', 'image']);
        
            
    }

    public function query(): QueryBuilder{
        if(get_user_data()->type == 'general')
            return Company::with(['profile','media', 'country'])->orderBy('id', 'ASC');
        return Company::with(['profile','media', 'country'])->whereCountryId(get_user_data()->country_id)->orderBy('id', 'ASC');
    }

    protected function getColumns(): array {
        return [
            ['name'=>'id','data'=>'id','title'=>'#','orderable'=>false,'searchable'=>false,],
            ['name'=>'image','data'=>'image','title'=>'Image','orderable'=>false,'searchable'=>false,],
            ['name'=>'name','data'=>'name','title'=> 'Name',],
            ['name'=>'status','data'=> 'status','title'=> 'Status',],
            ['name'=>'created_at','data'=> 'created_at','title'=>'Created_at',],
            ['name'=>'updated_at','data'=> 'updated_at','title'=>'Update_at',],
            ['name'=>'action','data'=> 'action','title'=>'Actions','exportable'=>false,'printable'=>false,'orderable'=>false,'searchable'=>false,],
        ];
    }
}