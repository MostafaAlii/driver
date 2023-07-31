<?php
namespace  App\Repositories\Contracts;
use App\DataTables\TimeZonesDataTable;
use App\Http\Requests\Dashboard\TimeZonesRequest;

interface TimeZoneRepositoryInterface {
    public function index(TimeZonesDataTable $timeZonesDataTable);
    public function store(TimeZonesRequest $request);
    public function update(TimeZonesRequest $request);
    public function destroy($request);
}
