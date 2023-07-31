<?php
namespace  App\Repositories\Contracts;
use Illuminate\Http\Request;
use App\DataTables\SosDataTable;
use App\Http\Requests\Dashboard\SosRequest;

interface SosRepositoryInterface {
    public function index(SosDataTable $sosDataTable);
    public function destroy(Request $request, $id);
    public function store(SosRequest $request);
    public function update(Request $request, $id);
    /*public function store($request);
    public function update($request);
    public function destroy($request);*/
}