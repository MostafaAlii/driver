<?php
namespace  App\Repositories\Contracts;
use App\DataTables\ZoneBoundDataTable;

interface ZoneBoundRepositoryInterface {
    public function index(ZoneBoundDataTable $zoneBoundDataTable);
    public function store($request);
    public function update($request);
    public function destroy($request);
}
