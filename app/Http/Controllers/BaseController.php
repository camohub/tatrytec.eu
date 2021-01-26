<?php

namespace App\Http\Controllers;


class BaseController extends Controller
{

	protected function setReffer()
	{
		session(['refferer' => request()->headers->get('referer')]);
	}

	protected function getRefferer()
	{
		return session('refferer') ?: '/';
	}

}
