<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\DataTables\SosDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SosRequest;
use App\Repositories\Contracts\SosRepositoryInterface;

class SosController extends Controller implements SosRepositoryInterface
{
    public function __construct(protected SosDataTable $sosDataTable, protected SosRepositoryInterface $sosInterface) {
        $this->sosDataTable = $sosDataTable;
        $this->sosInterface = $sosInterface;
    }

    public function index(SosDataTable $sosDataTable) {
        return $this->sosInterface->index($sosDataTable);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SosRequest $request) {
        return $this->sosInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        return $this->sosInterface->update($request, $id);
    }
    

    public function destroy(Request $request, $id) {
        return $this->sosInterface->destroy($request, $id);
    }
}
