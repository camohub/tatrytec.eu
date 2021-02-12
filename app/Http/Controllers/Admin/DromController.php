<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;
use App\Mail\Test;
use Illuminate\Support\Facades\Mail;


class DromController extends BaseController
{

	public function index()
	{
		Mail::to('vladimir.camaj@gmail.com')->send(new Test());
		return view('admin.drom.index');
	}
}
