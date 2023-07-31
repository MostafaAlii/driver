<?php
namespace  App\Repositories\Eloquents;
use App\Models\{Sos,ServiceLocations};
use Illuminate\Http\Request;
use App\DataTables\SosDataTable;
use App\Http\Requests\Dashboard\SosRequest;
use App\Repositories\Contracts\SosRepositoryInterface;

class SosRepository implements SosRepositoryInterface {
    public function __construct(protected SosDataTable $sosDataTable) {
        $this->sosDataTable = $sosDataTable;
    }
    
    public function index(SosDataTable $sosDataTable) {
        return $sosDataTable->render('dashboard.sos.index',['title' => 'SOS','servicesLocations' => ServiceLocations::get()]);
    }

    public function store(SosRequest $request) {
        try {
            Sos::create([
                'name' => $request->get('name'),
                'admin_id' => get_user_data()->id,
                'service_location_id' => $request->get('service_location_id'),
                'status' => $request->get('status'),
                'number' => $request->get('number'),
            ]);
            $notification = array(
                'message' =>  'Sos created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('sos.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $sos = Sos::findOrFail($id);
            $sos->update([
                'name' => $request->get('name'),
                'admin_id' => get_user_data()->id,
                'service_location_id' => $request->get('service_location_id'),
                'status' => $request->get('status'),
                'number' => $request->get('number'),
            ]);
            $notification = array(
                'message' =>  'Sos updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('sos.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy(Request $request, $id) {
        try {
            Sos::findOrFail($id)->delete();
            $notification = array(
               'message' =>  'Sos deleted successfully',
                'alert-type' =>'success'
            );
            return redirect()->route('sos.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}