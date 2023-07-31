<?php
namespace  App\Repositories\Eloquents;

use App\DataTables\UserTrashedDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UserDatatable;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {

    public function __construct(protected UserDatatable $userDataTable, protected UserTrashedDataTable $userTrashedDataTable) {
        $this->userDataTable = $userDataTable;
        $this->userTrashedDataTable = $userTrashedDataTable;
    }
    
    public function index(UserDatatable $userTrashedDataTable) {
        return $userTrashedDataTable->render('dashboard.users.index',['title' => 'Clients']);
    }

    public function users_trashed(UserTrashedDataTable $userTrashedDataTable) {
        return $userTrashedDataTable->render('dashboard.users.trashed',['title' => 'Trashed Clients']);
    }

    public function create() {
        return view('dashboard.users.create', ['title' => 'Create a new Client']);
    }

    public function store($request) {
        try {
            $requestData = $request->validated();
            $requestData['password'] = bcrypt($request->password);
            $user = User::create($requestData);
            if($request->hasFile('image')) 
                $user->addMediaFromRequest('image')->toMediaCollection(User::COLLECTION_NAME);
            $notification = array(
                'message' =>  'User created successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' =>  'An error occurred: '. $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function show(string $id) {
        try {
            $user = $this->getUser($id);
            return view('dashboard.users.profile', ['title' => 'Profile', 'user' => $user]);
        } catch (\Exception $e) {
            $notification = array(
                'message' =>  'An error occurred: '.$e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function updateStatus(Request $request, User $user) {
        try {
            $user->update(['status' => $request->status]);
            $notification = array(
                'message' =>  'User status updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);
        } catch (\Exception $e) {
            $notification = array(
                'message' =>  'An error occurred: '. $e->getMessage(),
                'alert-type' => 'error'
            );   
            return redirect()->back()->with($notification);
        }
    }

    public function restore(Request $request, $id) {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();
            $notification = array(
                'message' =>  'User restored successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
         try {
            $user = User::find($id);
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,'.$user->id,
                'image' => 'sometimes|nullable',
                'status' => 'sometimes|in:active,inactive',
                'phone' => 'sometimes|nullable|integer'
            ]);
            if($request->hasFile('image'))
                $user->addMediaFromRequest('image')->toMediaCollection(User::COLLECTION_NAME);
            $user->update($validatedData);
            $notification = array(
                'message' =>  'User updated successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);

         } catch (\Exception $e) {
             return redirect()->back()->with('error', $e->getMessage());
         }
    }

    protected function getUser($id) {
        return User::whereHas('profile', function ($query) use ($id) {
            $query->where('uuid', $id);
        })->firstOrFail();
    }

    public function destroy(Request $request, $id) {
        try {
            User::findOrFail($id)->delete();
            $notification = array(
               'message' =>  'User deleted successfully',
                'alert-type' =>'success'
            );
            return redirect()->route('users.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function forceDelete(Request $request, $id) {
        try {
            User::onlyTrashed()->findOrFail($id)->forceDelete();
            $notification = array(
                'message' =>  'User deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete_all() {
        
        try {
            if(request()->route()->getName() == 'users.destroy_all' && request()->has('delete_all')) {
                if(is_array(request('item')))
                    User::onlyTrashed()->whereIn('id', request('item'))->forceDelete();
                User::onlyTrashed()->whereId(request('item'))->forceDelete();
            } else {
                // if(is_array(request('item')))
                    User::whereIn('id', request('item'))->delete();
                // User::whereId(request('item'))->delete();
            }
            $notification = array(
                'message' => 'All selected clients deleted successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('users.index')->with($notification);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
}