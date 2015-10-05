<?php
use Ao\Data\Models\Headers;
use Ao\Data\Models\Images;
use Ao\Data\Models\Events;
use Ao\Data\Models\Posts;
use Ao\Data\Models\Categories;
class PagesController extends SiteController {

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
	public function __construct()
	{
		Parent::__construct();
	}

	/**
	 * Serve's the about page
	 * @return view
	*/
	public function about()
	{
		$page = $this->getPage("about", "page");
		$group = $this->getPage("about", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["page"] = $page;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.other.about', $this->viewdata);
	}

	/**
	 * Serve's the events page
	 * @return view
	*/
	public function events($category = null)
	{
		$page = $this->getPage("events", "page");
		$group = $this->getPage("events", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Get page primary data
		$list = Events::orderBy("schedule_starts", "asc")->where("schedule_starts", ">=", date("Y-m-d H:i:s"));
		if (!is_null($this->viewdata["searchVal"])) {
			$list = $list->where("title", "LIKe", "%".$this->viewdata["searchVal"]."%");
		}
		if (!is_null($category)) {
			$category = Categories::whereSlug($category)->first();
			if (!$category) { return App::abort(404); }
			$list = $list->where("category_id", $category->id);
			$category = $category->slug;
		}
		$list = $list->with(["category"])->paginate(31);
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["page"] = $page;
		$this->viewdata["searchIn"] = Request::url();
		$this->viewdata["list"] = $list;
		$this->viewdata["categories"] = Events::categories();
		$this->viewdata["selectedCategory"] = $category;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.other.events', $this->viewdata);
	}

	/**
	 * Serve's the events page
	 * @return view
	*/
	public function eventsFilter($year, $_2 = null, $_3 = null)
	{
		$category = null;
		if (is_numeric($_2)) { $time = $this->filterDates($year, $_2); }
		else{ $time = $this->filterDates($year); }
		if (!is_numeric($_2) && !is_null($_2)) { 
			$category = Categories::whereSlug($_2)->first();
			if (!$category) {  return App::abort(404); }
		}
		if (!is_null($_3)) { 
			$category = Categories::whereSlug($_3)->first();
			if (!$category) {  return App::abort(404); }
		}
		$page = $this->getPage("events", "page");
		$group = $this->getPage("events", "group");
		$headers = $page->headers()->orderBy("order", "asc")->get();
		// Get page images
		$images = ($group) ? $group->images()->get() : [];
		$imagesArr = [];
		foreach($images as $image){
			$imagesArr[$image->title] = $image;
		};
		$this->viewdata["pageImages"] = $imagesArr;
		// Get page primary data
		$list = Events::orderBy("schedule_starts", "asc")->where("schedule_starts", ">=", $time[0])->where("schedule_ends", "<=", $time[1]);
		if (!is_null($this->viewdata["searchVal"])) {
			$list = $list->where("title", "LIKe", "%".$this->viewdata["searchVal"]."%");
		}
		if (!is_null($category)) {
			$list = $list->where("category_id", $category->id);
			$category = $category->slug;
		}
		$list = $list->with("category")->paginate(31);
		// Prep view data
		$this->viewdata["headers"] = $headers;
		$this->viewdata["page"] = $page;
		$this->viewdata["searchIn"] = Request::url();
		$this->viewdata["list"] = $list;
		$this->viewdata["categories"] = Events::categories();
		$this->viewdata["selectedCategory"] = $category;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.other.events', $this->viewdata);
	}

	/**
	 * Serve's the contact page
	 * @return view
	*/
	public function contact()
	{
		$page = $this->getPage("contact", "page");
		$header = $page->headers()->orderBy("order", "asc")->first();
		// Prep view data
		$this->viewdata["header"] = $header;
		$this->viewdata["pageslug"] = $page->slug;
		$this->viewdata["page"] = $page;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.other.contact_us', $this->viewdata);
	}

	/**
	 * Serve's the programs page
	 * @return view
	*/
	public function programs()
	{
		$page = $this->getPage("programs", "page");
		$group = $this->getPage("programs", "group");
		$sections = $group->images()->orderBy("order", "asc")->get();
		$header = $page->headers()->orderBy("order", "asc")->first();
		// Prep sections data
		$sectionsArr = [];
		foreach ($sections as $section) {
			$section->background = $section->image;
			$section->group = $this->getPage(Slugify::slugify($section->title), "group");
			$section->list_group = $this->getPage(Slugify::slugify($section->title." List"), "group");
			$section->image = ($section->group) ? $section->group->images()->where("title", "Image")->first() : false;
			$section->list = ($section->list_group) ? $section->list_group->images()->orderBy("order", "asc")->get() : [];
			// Update section array
			$sectionsArr[] = $section;
		}
		// Prep view data
		$this->viewdata["header"] = $header;
		$this->viewdata["sections"] = $sectionsArr;
		$this->viewdata["pageslug"] = $page->slug;
		$this->viewdata["page"] = $page;
		$this->viewdata["pagedata"] = $this->getContentdata($page->slug);
		// Serve view
		return View::make('pages.other.programs', $this->viewdata);
	}

}
