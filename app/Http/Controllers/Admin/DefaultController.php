<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\BaseController;


class DefaultController extends BaseController
{

	public function index()
	{
		return view('admin.index');
	}
}
