<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ServiceLocationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ServiceLocationsRequest;
use App\Repositories\Contracts\ServiceLocationRepositoryInterface;
use Illuminate\Http\Request;

class ServiceLocationsController extends Controller
{
    public function __construct(protected ServiceLocationsDataTable $locationsDataTable, protected ServiceLocationRepositoryInterface $serviceLocationInterface) {
        $this->locationsDataTable = $locationsDataTable;
        $this->serviceLocationInterface = $serviceLocationInterface;
    }

    public function index(ServiceLocationsDataTable $locationsDataTable)
    {
        return $this->serviceLocationInterface->index($locationsDataTable);
    }


    public function store(ServiceLocationsRequest $request)
    {
        return $this->serviceLocationInterface->store($request);
    }


    public function update(ServiceLocationsRequest $request, string $id)
    {
        return $this->serviceLocationInterface->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->serviceLocationInterface->destroy($request);
    }
}
