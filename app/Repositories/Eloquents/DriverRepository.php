<?php

namespace App\Repositories\Eloquents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\DriverDataTable;
use App\DataTables\Trashed\DriverTrashedDataTable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\{Driver, DriverProfile, VehicleTypes, CarMake, CarModel, MediaStatus};
use App\Repositories\Contracts\DriverRepositoryInterface;

class DriverRepository implements DriverRepositoryInterface {
    public function __construct(protected DriverDataTable $driverDataTable, protected DriverTrashedDataTable $driverTrashedDataTable) {
        $this->driverDataTable = $driverDataTable;
        $this->driverTrashedDataTable = $driverTrashedDataTable;
    }

    public function index(DriverDataTable $driverDataTable) {
        return $driverDataTable->render('dashboard.drivers.index', ['title' => 'Drivers']);
    }

    public function drivers_trashed(DriverTrashedDataTable $driverTrashedDataTable) {
        return $driverTrashedDataTable->render('dashboard.drivers.trashed', ['title' => 'Trashed Drivers']);
    }

    public function create() {
        $countries = DB::table('countries')->get(['id', 'name']);
        return view('dashboard.drivers.create', ['title' => 'Create a new Driver', 'countries' => $countries]);
    }

    public function show(string $id) {
        try {
            $data = [];
            $data['driver'] = $this->getDriver($id);
            $data['vehicle_types'] = VehicleTypes::whereStatus(true)->get(['id', 'name']);
            $data['car_makes'] = CarMake::whereStatus(true)->get(['id', 'name']);
            $data['car_models'] = CarModel::whereStatus(true)->get(['id', 'name']);
            return view('dashboard.drivers.profile', ['title' => 'Profile', 'data' => $data]);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function updateProfile($request, $id) {
        try{
            $driver = DriverProfile::where('driver_id', $id)->first();
            $validatedData = $request->validate([
                'bio' => 'sometimes|string',
                'vehicle_type_id' => 'sometimes|exists:vehicle_types,id',
                'car_make_id' => 'sometimes|exists:car_makes,id',
                'car_model_id' => 'sometimes|exists:car_models,id',
                'car_number' => 'sometimes|string',
                'car_color' => 'sometimes|string',
                'car_front_side' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'car_back_side' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'car_right_side' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'car_left_side' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'driver_personal_identification_front' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'driver_personal_identification_back' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'driver_criminal_record' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,|max:2048',
                'nationality_id' => 'sometimes|nullable|numeric',
            ]);
            
            $driver->update($validatedData);
            $notification = array(
                    'message' =>  'Driver updated successfully',
                    'alert-type' => 'success'
                );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }   
    }

    
    public function store($request) {
        try {
            $requestData = $request->validated();
            $requestData['password'] = bcrypt($request->password);
            $driver = Driver::create($requestData);
            if ($request->hasFile('image'))
                $driver->addMediaFromRequest('image')->toMediaCollection(Driver::COLLECTION_NAME);
            $notification = array(

                'message' =>  'Driver created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function updateStatus(Request $request, Driver $driver) {
        try {
            $driver->update(['status' => $request->status]);
            $notification = array(
                'message' => 'Driver status updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function updateApprovalTripStatus(Request $request, Driver $driver) {
        try {
            $driver->profile->update(['status' => $request->status]);
            $types = $request->status == "active" ?  'online' : 'offline';
            DB::table('driver_activities')->where('driver_id', $driver->id)->update([
                'status' => $request->status,
                'type' => $types,
            ]);
            $notification = array(
                'message' => 'Driver approval trip status updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function mediaStatus(Request $request, $id) {
    
        try {
       
            $mediaStatus = MediaStatus::where('media_id', $id)->first();
            
            $mediaStatus->update(['status' => $request->status]);
            $notification = array(
                'message' => 'Media status updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function update(Request $request, $id) {
        try {
            $driver = Driver::find($id);
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:drivers,email,' . $driver->id,
                'image' => 'sometimes|nullable',
                'status' => 'sometimes|in:active,inactive',
                'gender' => 'sometimes|in:male,female',
                'phone' => 'sometimes|nullable|numeric',
                'country_id' => 'sometimes|nullable|exists:countries,id',
            ]);
            if ($request->hasFile('image'))
                $driver->addMediaFromRequest('image')->toMediaCollection(Driver::COLLECTION_NAME);
            $driver->update($validatedData);
            $notification = array(
                'message' =>  'Driver updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, $id) {
        try {
            Driver::findOrFail($id)->delete();
            $notification = array(
                'message' => 'User deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function restore(Request $request, $id) {
        try {
            $driver = Driver::onlyTrashed()->findOrFail($id);
            $driver->restore();
            $notification = array(
                'message' => 'Driver restored successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function forceDelete(Request $request, $id) {
        try {
            Driver::onlyTrashed()->findOrFail($id)->forceDelete();
            $notification = array(
                'message' => 'Driver deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('drivers.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    protected function getDriver($id) {
        return Driver::with(['profile','driverDetails'])->whereHas('profile', function ($query) use ($id) {
            $query->where('uuid', $id);
        })->firstOrFail();
    }

    public function getMaps() {
        $driversLocation = Driver::whereOnline(true)->with(['profile'])->get(['id', 'name', 'lat', 'lan', 'phone']);
        $locations = [];
        foreach ($driversLocation as $driver) {
            $locations[] = [
                'id' => $driver->id,
                'name' => $driver->name,
                'lat' => $driver->lat,
                'lan' => $driver->lan,
                'phone' => $driver->phone,
                'profile' => $driver->profile->uuid
            ];
        }
        return view('dashboard.drivers.maps', ['title' => 'Drivers Maps', 'data' => json_encode($locations)]);
    }
}