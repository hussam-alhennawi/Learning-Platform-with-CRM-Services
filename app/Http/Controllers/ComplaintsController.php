<?php

namespace App\Http\Controllers;

use App\Complaint;
use App\User;
use Illuminate\Http\Request;

class ComplaintsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu_active='complaints';
        $complaints=Complaint::paginate(10);
        return view('backEnd.complaints.index',compact('menu_active','complaints'));
    }
    
}
