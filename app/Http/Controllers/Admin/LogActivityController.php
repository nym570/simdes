<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ActivityLogDataTable;

class LogActivityController extends Controller
{
    public function index(ActivityLogDataTable $dataTable)
    {

        $title = 'Manajemen Log';
		 return $dataTable->render('admin.log.index',compact('title'));
    }
}
