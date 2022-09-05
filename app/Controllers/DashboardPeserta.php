<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DashboardPeserta extends BaseController
{
    public function index()
    {
        return view('pages/DashboardPeserta');
    }
}
