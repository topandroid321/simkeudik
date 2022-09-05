<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardKaprog extends BaseController
{
    public function index()
    {
        return view('pages/DashboardKaprog');
    }
}
