<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;

class ApiCompanyController extends Controller {

    /**
     * Return the contents of User table in tabular form
     *
     */
    public function getCompanyTabular() {
        $company = Company::orderBy('id', 'desc')->get();
        return response()->json($company);
    }

}
