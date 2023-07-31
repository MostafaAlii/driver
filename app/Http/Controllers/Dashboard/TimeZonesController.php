<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\TimeZonesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TimeZonesRequest;
use App\Repositories\Contracts\TimeZoneRepositoryInterface;
use Illuminate\Http\Request;

class TimeZonesController extends Controller
{
    public function __construct(protected TimeZonesDataTable $timeZonesDataTable, protected TimeZoneRepositoryInterface $timeZoneInterface) {
        $this->timeZonesDataTable = $timeZonesDataTable;
        $this->timeZoneInterface = $timeZoneInterface;
    }

    public function index(TimeZonesDataTable $timeZonesDataTable)
    {
        return $this->timeZoneInterface->index($timeZonesDataTable);
    }


    public function store(TimeZonesRequest $request)
    {
        return $this->timeZoneInterface->store($request);
    }


    public function update(TimeZonesRequest $request, string $id)
    {
        return $this->timeZoneInterface->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->timeZoneInterface->destroy($request);
    }
}
