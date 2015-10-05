<?php namespace Ao\Wcp\Controllers;
use Ao\Data\Models\Datagroups;
use Ao\Data\Models\Basicdata;
class WcpController extends \Controller{

	/*
	* @Var array
	* @Access Level Protected
	*/
	protected $filterExceptions = [];

	/*
	* @Var array
	* @Access Level Protected
	*/
	protected $viewdata = [];

	/*
	* @Var object
	* @Access Level Protected
	*/
	protected $model = null;

	public function __construct()
	{
		// Set default view message
		$this->viewdata["view_message"] = null;
		// Check for flashed site messages
		if (\Session::has('system_message')) {
			$system_message = \Session::get('system_message');
			if ($system_message["access"] == "wcp") {
				$this->viewdata["view_message"] = $system_message;
			}
		}
		// Load user data
		$user_data = \Sentry::getUser();
		if(count($user_data) > 0){
			$user_data = \Sentry::findUserById($user_data->id);
			$user_group = $user_data->getGroups();
			$this->viewdata["user_data"] = $user_data;
			$this->viewdata["user_group"] = $user_group[0];
			// Load basic data
			$basic_info = Basicdata::orderBy("created_at", "desc")->first();
			$this->viewdata["basic_info"] = $basic_info;
		}
	}

	/**
	* @Param none
	* @Access Level Protected
	* return @Array
	*/
	protected function datagroupOptions()
	{
		$dataoptions = Datagroups::orderBy("name", "asc")->get()->groupBy("type");
		$dataoptionOptions = [];
		foreach ($dataoptions as $k => $v) {
			$dataoptionOptions[$k] = [];
			$dataoptionOptions[$k][""] = "Select ".ucwords(str_replace("-", " ", $k));
			foreach ($v as $dataoption) {
				$dataoptionOptions[$k][$dataoption->id] = $dataoption->name;
			}
		}
		return $dataoptionOptions;
	}

	/**
	* @Param $data Array 
	* @Access Level Protected
	* return none
	*/
	protected function flashMessage(Array $data)
	{
		\Session::flash("system_message", ["level"=>$data['level'], "type"=>$data['type'], "message"=>$data['message'],  "access"=>$data['access']]);
	}
	
}

