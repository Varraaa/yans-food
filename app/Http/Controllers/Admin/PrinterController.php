<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PrinterController extends Controller
{
    public function index()
    {
        return view('admin.printers.index');
    }
}
