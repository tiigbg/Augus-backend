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




Auth::routes();


Route::get('iconFile/{id}','IconController@iconFile');
Route::get('imageFile/{id}','ImageController@imageFile');
Route::get('audioFile/{id}','AudioController@audioFile');
Route::get('videoFile/{id}','VideoController@videoFile');
Route::get('meshFile/{id}','MeshController@meshFile');
Route::get('triggerMarkerFile/{id}','TriggerMarkerController@triggerMarkerFile');
Route::get('signlanguageFile/{id}','SignlanguageController@signlanguageFile');


Route::group(['middleware' => ['auth']], function() {
	
	Route::get('/', 'HomeController@index');
	
	Route::get('profile', function () {
    	// TODO
	});

	Route::get('/exhibitions', function(){
		$exhibitions = App\Section::whereNull('parent_id')->get();
		return view('exhibitions')->with('exhibitions',$exhibitions);
	})->name('exhibitions');

	Route::get('/users', function(){
		$users = App\User::All();
		return view('users')->with('users',$users);
	})->name('users');


	Route::get('/exhibition/{exhibitionId}', function($exhibitionId){
		$exhibition = App\Section::where('id', '=', $exhibitionId)->first();
		$children = App\Section::find($exhibitionId)->children;
		return view('exhibition')->with('exhibition', $exhibition)->with('children', $children);
	});

	Route::get('/section/{sectionId}', function($sectionId){
		$section = App\Section::find($sectionId);
		$data = [
			'section' => $section,
			'icon' => $section->sectionIcon,
			'children' => $section->children,
			'titles' => $section->titles,
			'texts' => $section->texts,
			'images' => $section->images,
			'signlanguages' => $section->signlanguages,
			'meshes' => $section->meshes,
			'triggerMarkers' => $section->triggerMarkers,
			'audios' => $section->audios,
			'videos' => $section->videos,
		 ];
		return view('section', $data);
	});

	// create 
	Route::post('newSection', 'SectionController@store')->name('newSection');
	Route::post('addColors', 'SectionController@addColors')->name('addColors');

	// update
	Route::put('updateSection', 'SectionController@update')->name('updateSection');

	// delete
	Route::delete('deleteSection', 'SectionController@delete')->name('deleteSection');


	//Route::get('image-upload-with-validation',['as'=>'getimage','uses'=>'ImageController@getImage']);
    Route::post('image-upload-with-validation',['as'=>'postimage','uses'=>'ImageController@postImage']);
    Route::post('icon-upload-with-validation',['as'=>'posticon','uses'=>'IconController@postIcon']);

    Route::resource('iconz', 'IconController');
	Route::resource('texts', 'TextController');
    Route::resource('audios', 'AudioController');
    Route::resource('meshes', 'MeshController');
    Route::resource('triggerMarkers', 'TriggerMarkerController');
    Route::resource('images', 'ImageController');
    Route::resource('videos', 'VideoController');
    Route::resource('signlanguages', 'SignlanguageController');
    Route::resource('audios', 'AudioController');
    Route::resource('meshes', 'MeshController', ['except' => ['show']]);
    Route::resource('triggerMarkers', 'TriggerMarkerController');
});
