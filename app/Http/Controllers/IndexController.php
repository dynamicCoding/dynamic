<?php

namespace App\Http\Controllers;


class IndexController extends Controller
{
	public function home()
	{
		return $this->view->render('index.home')->assign(['title' => 'home']);
	}
}