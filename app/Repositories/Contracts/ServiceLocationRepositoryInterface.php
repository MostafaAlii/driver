<?php
namespace  App\Repositories\Contracts;
use App\DataTables\ServiceLocationsDataTable;
use App\Http\Requests\Dashboard\ServiceLocationsRequest;

interface ServiceLocationRepositoryInterface {
    public function index(ServiceLocationsDataTable $locationsDataTable);
    public function store(ServiceLocationsRequest $request);
    public function update(ServiceLocationsRequest $request);
    public function destroy($request);
}
