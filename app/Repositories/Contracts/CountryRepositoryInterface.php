<?php
namespace  App\Repositories\Contracts;
use App\DataTables\CountryDataTable;
use Illuminate\Http\Request;

interface CountryRepositoryInterface {
    public function index(CountryDataTable $countryDataTable);

    public function changeStatusCountry(Request $request);
}
