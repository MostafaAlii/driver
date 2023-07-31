<?php
namespace  App\Repositories\Eloquents;
use App\DataTables\ZoneTypesDataTable;
use App\Models\ZoneTypes;
use App\Repositories\Contracts\ZoneTypeRepositoryInterface;
use Illuminate\Http\Request;
class ZoneTypeRepository implements ZoneTypeRepositoryInterface {

    public function index(ZoneTypesDataTable $zoneTypesDataTable)
    {
        return $zoneTypesDataTable->render('dashboard.zoneTypes.index',['title' => 'zoneTypes']);
    }

    public function store($request) {

    }

    public function update(Request $request)
    {

        try {
            ZoneTypes::findorfail($request->id)->update([
                'status' => $request->status,
            ]);
            $notification = array(
                'message' => 'ZoneTypes Updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('zoneTypes.index')->with($notification);
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function destroy($request) {

    }
}
