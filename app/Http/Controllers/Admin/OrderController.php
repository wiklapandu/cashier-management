<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index()
    {
        return view('admin.order.overviews');
    }

    public function store()
    {
        
    }

    public function create()
    {
        return view('admin.order.create');
    }
}
