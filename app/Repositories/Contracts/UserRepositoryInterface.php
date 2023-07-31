<?php
namespace  App\Repositories\Contracts;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\{UserDataTable,UserTrashedDataTable};
use App\Http\Requests\Dashboard\UserValidatationRequest;

interface UserRepositoryInterface {
    public function index(UserDataTable $userDataTable);
    public function users_trashed(UserTrashedDataTable $userTrashedDataTable);
    public function create();
    public function store(UserValidatationRequest $request);
    public function show(string $id);
    public function updateStatus(Request $request, User $user);
    public function update(Request $request, $id);
    public function destroy(Request $request, $id);
    public function forceDelete(Request $request, $id);
    public function restore(Request $request, $id);
    public function delete_all();
    
}