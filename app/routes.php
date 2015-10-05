<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get("/", "PostsController@index");
Route::get("about/", "PagesController@about");
Route::get("events", "PagesController@events");
Route::get("events/c/{category}", "PagesController@events");
Route::get("events/{year}", "PagesController@eventsFilter")->where("year", "[0-9]+");
Route::get("events/{year}/{two}", "PagesController@eventsFilter")->where(["year"=>"[0-9]+"]);
Route::get("events/{year}/{two}/{category}", "PagesController@eventsFilter")->where(["year"=>"[0-9]+", "two"=>"[0-9]+"]);
Route::get("contact", "PagesController@contact");
Route::get("gallery", "GalleryController@index");
Route::get("gallery/{id}", "GalleryController@show");
Route::get("a/{username}", "AuthorsController@index");
Route::get("c", "CategoriesController@index");
Route::get("c/{slug}", "CategoriesController@show");
Route::get("{year}", "PostsController@filter")->where("year", "[0-9]+");
Route::get("{year}/{month}", "PostsController@filter")->where(["year"=>"[0-9]+", "month"=>"[0-9]+"]);
Route::get("{year}/{month}/{day}", "PostsController@filter")->where(["year"=>"[0-9]+", "month"=>"[0-9]+","day"=>"[0-9]+"]);
Route::get("{year}/{month}/{date}/{slug}", "PostsController@show")->where(["year"=>"[0-9]+", "month"=>"[0-9]+","day"=>"[0-9]+"]);