<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('profile', function () {
    // Only authenticated users may enter...
})->middleware('auth');


Auth::routes();


Route::group(['middleware' => ['auth']], function() {
	
	Route::get('/home', 'HomeController@index');
	
	Route::get('/exhibitions', function(){
		$exhibitions = App\Section::whereNull('parent_id')->get();
		return view('exhibitions')->with('exhibitions',$exhibitions);
		#return $exhibitions;
	})->name('exhibitions');

	Route::get('/allexhibitions', 'SectionController@getAllExhibitions');

	Route::get('/exhibition/{exhibitionId}', function($exhibitionId){
		$exhibition = App\Section::where('id', '=', $exhibitionId)->first();
		$children = App\Section::find($exhibitionId)->children;
		return view('exhibition')->with('exhibition', $exhibition)->with('children', $children);
	});

	Route::get('/section/{sectionId}', function($sectionId){
		$section = App\Section::find($sectionId);
		$data = [
			'section' => $section,
			'children' => $section->children,
			'titles' => $section->titles,
			'texts' => $section->texts
		 ];
		return view('section', $data);
	});


	// create 
	Route::post('newSection', 'SectionController@store')->name('newSection');

	// update
	Route::put('updateSection', 'SectionController@update')->name('updateSection');

	// delete
	Route::delete('deleteSection', 'SectionController@delete')->name('deleteSection');

	Route::resource('texts', 'TextController');


	Route::get('upload', function() {
	  return View::make('upload');
	});
	Route::post('apply/upload', 'ApplyController@upload');
});
