<?php
namespace  App\Repositories\Eloquents;
use App\DataTables\ZoneBoundDataTable;
use App\Models\ZoneBound;
use App\Repositories\Contracts\ZoneBoundRepositoryInterface;
use Illuminate\Http\Request;
class ZoneBoundRepository implements ZoneBoundRepositoryInterface {

    public function index(ZoneBoundDataTable $zoneBoundDataTable)
    {
        return $zoneBoundDataTable->render('dashboard.zoneBound.index',['title' => 'zoneBound']);
    }

    public function store($request) {

    }

    public function update($request) {

    }

    public function destroy($request) {

    }
}
