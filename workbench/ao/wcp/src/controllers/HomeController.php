<?php namespace Ao\Wcp\Controllers;

use \Input;
use \Redirect;
use \Session;
use \View;
use Ao\Data\Models\Basicdata;
use Ao\Data\Models\Notification;

class HomeController extends WcpController{

	public function __construct()
	{
		// Add authentication filter
		$this->beforeFilter("auth.wcp");
		// Load parent construct
		Parent::__construct();
		// Set current menu
		$this->viewdata["menu"] = 1;
	}

	public function index()
	{
		return View::make('wcp::pages.home.dashboard', $this->viewdata);
	}
} 

