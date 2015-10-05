<?php 

	Route::group(["prefix"=>"admin"], function(){

		Route::get("logout", function(){
			// Log user out
			Sentry::logout();
			// Flash system message
			Session::flash("system_message",["level"=>"success", "access"=>"wcp", "type" => "login", "message" => "You've logged out!"]);			
			// Return a response			
			return Redirect::to('admin/login');
		});

		// Home routes
		Route::get("/", "Ao\Wcp\Controllers\HomeController@index");
		// Forms routes
		Route::delete("forms/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\FormsController@bulkDestroy"]);
		Route::get("forms/{id}/elements", "Ao\Wcp\Controllers\FormsController@elements");
		Route::get("forms/{id}/submitions", "Ao\Wcp\Controllers\FormsController@submitions");
		Route::post("forms/{id}/elements/{type}", "Ao\Wcp\Controllers\FormsController@createElements");
		Route::delete("forms/{id}/elements/bulk", "Ao\Wcp\Controllers\FormsController@bulkDestroyElements");
		Route::delete("forms/{id}/elements/{eid}", "Ao\Wcp\Controllers\FormsController@destroyElement");
		Route::delete("forms/{id}/submitions/bulk", "Ao\Wcp\Controllers\FormsController@bulkDestroySubmitions");
		Route::delete("forms/{id}/submitions/{sid}", "Ao\Wcp\Controllers\FormsController@destroySubmition");
		Route::put("forms/{id}/elements/{eid}", "Ao\Wcp\Controllers\FormsController@updateElement");
		Route::put("forms/{id}/submition/{sid}", "Ao\Wcp\Controllers\FormsController@updateElement");
		Route::resource("forms", "Ao\Wcp\Controllers\FormsController");
		// Menu builder routes
		Route::delete("menubuilder/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\MenubuilderController@bulkDestroy"]);
		Route::get("menubuilder/{id}/submenus", "Ao\Wcp\Controllers\MenubuilderController@show");
		Route::resource("menubuilder", "Ao\Wcp\Controllers\MenubuilderController");
		// Categories routes
		Route::delete("categories/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\CategoriesController@bulkDestroy"]);
		Route::resource("categories", "Ao\Wcp\Controllers\CategoriesController");
		// Headers routes
		Route::delete("headers/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\HeadersController@bulkDestroy"]);
		Route::resource("headers", "Ao\Wcp\Controllers\HeadersController");
		// Image routes
		Route::delete("images/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\ImagesController@bulkDestroy"]);
		Route::resource("images", "Ao\Wcp\Controllers\ImagesController");
		// Content data routes
		Route::delete("content_data/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\ContentdataController@bulkDestroy"]);
		Route::resource("content_data", "Ao\Wcp\Controllers\ContentdataController");
		// Events routes
		Route::post('events/{id}', ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\EventsController@update"]);
		Route::post('events/{id}/delete', ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\EventsController@destroy"]);
		Route::resource("events", "Ao\Wcp\Controllers\EventsController");
		// Posts routes
		Route::delete("posts/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\PostsController@bulkDestroy"]);
		Route::resource("posts", "Ao\Wcp\Controllers\PostsController");
		Route::group(["prefix"=>"posts/{id}/comments"], function(){
			// Comment routes
			Route::get("", "Ao\Wcp\Controllers\PostsController@comments");
			Route::post("", "Ao\Wcp\Controllers\PostsController@storecomment");
			Route::put("{id2}", "Ao\Wcp\Controllers\PostsController@updatecomment");
			Route::delete("bulk", "Ao\Wcp\Controllers\PostsController@destroycomments");
			Route::delete("{id2}", "Ao\Wcp\Controllers\PostsController@destroycomment");
		});
		// Accounts routes
		Route::put("accounts/{id}/change_password", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\AccountsController@change_password"]);
		Route::put("accounts/{id}/activate", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\AccountsController@activate"]);		
		Route::delete("accounts/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\AccountsController@bulkDestroy"]);
		Route::resource("accounts", "Ao\Wcp\Controllers\AccountsController");
		// Datagroups creator routes
		Route::delete("datagroups/bulk", ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\DatagroupsController@bulkDestroy"]);
		Route::resource("datagroups", "Ao\Wcp\Controllers\DatagroupsController");
		// Settings routes
		Route::get("basic_info", "Ao\Wcp\Controllers\SettingsController@basic_info");
		Route::put("basic_info/{id}", "Ao\Wcp\Controllers\SettingsController@basic_info_edit");
		Route::put("basic_info/{id}/logo", "Ao\Wcp\Controllers\SettingsController@basic_info_logo");
		// Authentication routes
		Route::get('login', "Ao\Wcp\Controllers\AuthController@showLogin");
		Route::post('login', ["before"=>"csrf", "uses"=>"Ao\Wcp\Controllers\AuthController@login"]);

	});