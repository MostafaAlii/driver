<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\{UserDataTable,UserTrashedDataTable};
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Http\Requests\Dashboard\UserValidatationRequest;

class UserController extends Controller implements UserRepositoryInterface {
    public function __construct(protected UserDatatable $userDataTable,protected UserTrashedDataTable $userTrashedDataTable ,protected UserRepositoryInterface $userInterface) {
        $this->userDataTable = $userDataTable;
        $this->userInterface = $userInterface;
        $this->userTrashedDataTable = $userTrashedDataTable;
    }

    public function index(UserDataTable $userDataTable) {
        return $this->userInterface->index($userDataTable);
    }

    public function users_trashed(UserTrashedDataTable $userTrashedDataTable) { 
        return $this->userInterface->users_trashed($userTrashedDataTable);
    }

    public function restore(Request $request, $id) {
        return $this->userInterface->restore($request, $id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return $this->userInterface->create();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserValidatationRequest $request) {
        return $this->userInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        return $this->userInterface->show($id);
    }

    /**
     * Update the specified resource status in storage.
     */
    public function updateStatus(Request $request, User $user) {
        return $this->userInterface->updateStatus($request, $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        return $this->userInterface->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id) {
        return $this->userInterface->destroy($request, $id);
    }

    public function forceDelete(Request $request, $id) {
        return $this->userInterface->forceDelete($request, $id);
    }

    public function delete_all() {
        return $this->userInterface->delete_all();
    }
}