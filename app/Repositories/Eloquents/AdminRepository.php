<?php

namespace App\Repositories\Eloquents;

use App\Models\Admin;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\DataTables\AdminDataTable;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface {
    public function __construct(protected AdminDatatable $adminDataTable) {
        $this->adminDataTable = $adminDataTable;
    }

    public function index(AdminDatatable $adminDataTable) {
        return $adminDataTable->render('dashboard.admins.index', ['title' => 'Admins']);
    }

    public function create() {
        return view('dashboard.admins.create', ['title' => 'Create a new administrator' , 'countries' => Country::whereStatus(true)->get()]);
    }

    public function store($request) {
        try {
            $requestData = $request->validated();
            $requestData['password'] = bcrypt($request->password);
            $admin = Admin::create($requestData);
            if ($request->hasFile('image'))
                $admin->addMediaFromRequest('image')->toMediaCollection(Admin::COLLECTION_NAME);
            $notification = array(
                'message' => 'Admin created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admins.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }


    public function show(string $id) {
        try {
            $admin = $this->getAdmin($id);
            return view('dashboard.admins.profile', ['title' => 'Profile', 'admin' => $admin]);
        } catch (\Exception $e) {
            $notification = array(
                'message' => 'An error occurred: ' . $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function updateStatus(Request $request, Admin $admin) {
        try {
            $admin->update(['status' => $request->status]);
            $notification = array(
                'message' => 'Admin status updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admins.index')->with($notification);
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
            $admin = Admin::find($id);
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:admins,email,' . $admin->id,
                'status' => 'sometimes|in:active,inactive',
                'type' => 'sometimes|in:supervisor,admin,general',
                'country_id' => 'required|exists:countries,id',
                'avatar' => 'sometimes|nullable|image|mimes:jpeg,png,jpg|max:2048',
                'phone' => 'sometimes|nullable|numeric|digits_between:8,20|unique:admins,phone,' . $admin->id,
            ]);
    
            DB::transaction(function () use ($admin, $validatedData, $request) {
                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');
                    $avatarName = 'avatar.' . $avatar->getClientOriginalExtension();
                    $avatar->move(public_path("dashboard/images/admins/{$admin->email}{$admin->phone}_{$admin->profile->uuid}"), $avatarName);
                    $validatedData['avatar'] = $avatarName;
                    $admin->profile()->update(['avatar' => $avatarName]);
                }
    
                $admin->update($validatedData);
            });
    
            $notification = array(
                'message' => 'Admin updated successfully',
                'alert-type' => 'success'
            );
    
            return redirect()->route('admins.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    

    protected function getAdmin($id) {
        return Admin::whereHas('profile', function ($query) use ($id) {
            $query->where('uuid', $id);
        })->firstOrFail();
    }

    public function destroy(Request $request, $id) {
        try {
            Admin::findOrFail($id)->delete();
            $notification = array(
                'message' => 'Admin deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admins.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function destroy_all() {
        try {
            if(is_array(request('item')))
                Admin::whereIn('id', request('item'))->delete();
            Admin::whereId(request('item'))->delete();
            $notification = array(
                'message' => 'All selected admins deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('admins.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
