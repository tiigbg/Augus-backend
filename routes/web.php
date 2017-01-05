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



Route::get('/allexhibitions', 'SectionController@getAllExhibitions');

Route::get('/alldata', 'SectionController@getAllData');

Route::get('profile', function () {
    // Only authenticated users may enter...
})->middleware('auth');


Auth::routes();


Route::get('imageFile/{id}','ImageController@imageFile');
Route::get('audioFile/{id}','AudioController@audioFile');
Route::get('videoFile/{id}','VideoController@videoFile');
Route::get('signlanguageFile/{id}','SignlanguageController@signlanguageFile');


Route::group(['middleware' => ['auth']], function() {
	
	Route::get('/', 'HomeController@index');
	
	Route::get('/exhibitions', function(){
		$exhibitions = App\Section::whereNull('parent_id')->get();
		return view('exhibitions')->with('exhibitions',$exhibitions);
		#return $exhibitions;
	})->name('exhibitions');


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
			'texts' => $section->texts,
			'images' => $section->images,
			'videos' => $section->videos,
			'audios' => $section->audios,
			'signlanguages' => $section->signlanguages,
		 ];
		return view('section', $data);
	});


	// create 
	Route::post('newSection', 'SectionController@store')->name('newSection');

	// update
	Route::put('updateSection', 'SectionController@update')->name('updateSection');

	// delete
	Route::delete('deleteSection', 'SectionController@delete')->name('deleteSection');


	Route::get('image-upload-with-validation',['as'=>'getimage','uses'=>'ImageController@getImage']);
    Route::post('image-upload-with-validation',['as'=>'postimage','uses'=>'ImageController@postImage']);


	Route::resource('texts', 'TextController');
    Route::resource('images', 'ImageController');
    Route::resource('videos', 'VideoController');
    Route::resource('signlanguages', 'SignlanguageController');
    Route::resource('audios', 'AudioController');
});
