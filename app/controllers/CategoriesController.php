<?php
use Ao\Data\Models\Categories;
class CategoriesController extends SiteController {

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
	public function __construct(Categories $model)
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
		$page = $this->getPage("categories", "page");
		$group = $this->getPage("categories", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Get posts
		$list = $this->model->where("type", "posts")->orderBy("created_at", "desc")->with(["post"]);
		if (!is_null($this->viewdata["searchVal"])) {
			$list = $list->where("name", "LIKE", "%".$this->viewdata["searchVal"]."%");
		}
		$list = $list->paginate(15);
		// Get posts count for categories
		$listArr = [];
		foreach($list as $item){
			$item->postsCount = $item->posts()->count();
			$listArr[] = $item;
		}
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["page"] = $page;
		$this->viewdata["list"] = $listArr;
		$this->viewdata["pagination"] = $list;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		$this->viewdata["searchIn"] = Request::url();
		// Serve view
		return View::make('pages.categories.list', $this->viewdata);
	}

	/**
	 * Serve's a specific resource
	 * @return view
	*/
	public function show($slug)
	{
		// Find post model
		$item = $this->model->where("type", "posts")
					->where("slug", $slug)->first();
		// Validate returned post model
		if (!$item) {
			return App::abort(404);
		}
		// Get posts
		$list = $item->posts()->where("publish_state", 1)->orderBy("created_at", "desc")->with(["author", "category"]);
		if (!is_null($this->viewdata["searchVal"])) {
			$list = $list->where("title", "LIKE", "%".$this->viewdata["searchVal"]."%");
		}
		$list = $list->paginate(15);
		// Get page data
		$page = $this->getPage("categories", "page");
		$group = $this->getPage("categories", "group");
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
		$this->viewdata["list"] = $list;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		$this->viewdata["searchIn"] = Request::url();
		// Serve view
		return View::make('pages.categories.show', $this->viewdata);
	}

}
