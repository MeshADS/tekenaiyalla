<?php
use Ao\Data\Models\Posts;
class PostsController extends SiteController {

	/*
	|--------------------------------------------------------------------------
	| Default Pages Controller
	|--------------------------------------------------------------------------
	|
	| Serve's views for routes without explicit functions
	|
	*/

	/**
	 * Controller construct method
	*/
	public function __construct(Posts $model)
	{
		Parent::__construct();

		$this->model = $model;
	}

	/**
	 * Serve's a list of resources
	 * @return view
	*/
	public function index()
	{
		$page = $this->getPage("home", "page");
		$group = $this->getPage("home", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Get posts
		$list = $this->model->published()->orderBy("created_at", "desc")->with(["author", "category"]);
		if (!is_null($this->viewdata["searchVal"])) {
			$list = $list->where("title", "LIKE", "%".$this->viewdata["searchVal"]."%");
		}
		$list = $list->paginate(15);
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["page"] = $page;
		$this->viewdata["list"] = $list;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.posts.list', $this->viewdata);
	}

	/**
	 * Serve's a list of resources
	 * @return view
	*/
	public function filter($year, $month = null, $day = null)
	{
		// Convert filter date
		$time = $this->filterDates($year, $month, $day);
		// Get posts
		$list = $this->model->published()
					->where("created_at", ">=", $time[0])
					->where("created_at", "<=", $time[1])
					->orderBy("created_at", "desc")->with(["author", "category"]);
		if (!is_null($this->viewdata["searchVal"])) {
			$list = $list->where("title", "LIKE", "%".$this->viewdata["searchVal"]."%");
		}
		$list = $list->paginate(15);
		// Get page data
		$page = $this->getPage("home", "page");
		$group = $this->getPage("home", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Get posts
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["searchIn"] = Request::url();
		$this->viewdata["page"] = $page;
		$this->viewdata["list"] = $list;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.posts.list', $this->viewdata);
	}

	/**
	 * Serve's a specific resource
	 * @return view
	*/
	public function show($year, $month, $day, $slug)
	{
		// Convert filter date
		$time = $this->filterDates($year, $month, $day);
		// Find post model
		$item = $this->model->published()
					->where("created_at", ">=", $time[0])
					->where("created_at", ">=", $time[0])
					->where("slug", $slug)
					->with(["author", "category"])->first();
		// Validate returned post model
		if (!$item) {
			return App::abort();
		}
		// Grab social data
		$item->facebookCount = $this->readableNumber($this->getFacebookCount(Request::url()));
		$item->twitterCount = $this->readableNumber($this->getTwitterCount(Request::url()));
		$item->plusCount = $this->readableNumber($this->getPlusCount(Request::url()));
		// Get page data
		$page = $this->getPage("post", "page");
		$group = $this->getPage("post", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Get posts
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["page"] = $page;
		$this->viewdata["item"] = $item;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.posts.show', $this->viewdata);
	}
}
