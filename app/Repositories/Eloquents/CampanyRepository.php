<?php
namespace  App\Repositories\Eloquents;
use App\Models\Company;
use Illuminate\Http\Request;
use App\DataTables\CompanyDataTable;
use App\Models\Country;
use App\Repositories\Contracts\CampanyRepositoryInterface;
class CampanyRepository implements CampanyRepositoryInterface {
    public function __construct(protected CompanyDataTable $companyDataTable) {
        $this->companyDataTable = $companyDataTable;
    }

    public function index(CompanyDataTable $companyDataTable) {
        return $companyDataTable->render('dashboard.company.index',['title' => 'Companies', 'countries'=>Country::get()]);
    }

    public function show(string $id) {
        try {
            $company = $this->getCompany($id);
            return view('dashboard.company.profile', ['title' => 'Profile', 'company' => $company]);
        } catch (\Exception $e) {
            $notification = array(
                'message' =>  'An error occurred: '.$e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    protected function getCompany($id) {
        return Company::whereHas('profile', function ($query) use ($id) {
            $query->where('uuid', $id);
        })->firstOrFail();
    }

    public function updateStatus(Request $request, Company $company) {
        try {
            $company->update(['status' => $request->status]);
            $notification = array(
                'message' =>  'Company status updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('company.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' =>  'An error occurred: '. $e->getMessage(),
                'alert-type' => 'error'
            );   
            return redirect()->back()->with($notification);
        }
    }
    
    public function store($request) {
        try {
            $requestData = $request->validated();
            $company = Company::create($requestData);
            if($request->hasFile('image')) 
                $company->addMediaFromRequest('image')->toMediaCollection(Company::COLLECTION_NAME);
            $notification = array(
                'message' =>  'Company created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('company.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' =>  'An error occurred: '. $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function update(Request $request, $id) {
        try {
            $company = Company::findOrFail($id);
            if($request->hasFile('image'))
                $company->addMediaFromRequest('image')->toMediaCollection(Company::COLLECTION_NAME);
            $company->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'state' => $request->get('state'),
                'postal_code' => $request->get('postal_code'),
                'admin_id' => get_user_data()->id,
                'country_id' => $request->get('country_id'),
                'status' => $request->get('status'),
                'mobile' => $request->get('mobile'),
                'landline' => $request->get('landline'),
                'address' => $request->get('address'),
            ]);
            $notification = array(
                'message' =>  'Company updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('company.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy(Request $request, $id) {
        try {
            Company::findOrFail($id)->delete();
            $notification = array(
               'message' =>  'Company deleted successfully',
                'alert-type' =>'success'
            );
            return redirect()->route('company.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}