<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
   // return phpinfo();
    return "hello From List";
});


	$app->group(['prefix' => 'v1','namespace' => 'App\Http\Controllers'], function () use ($app) {
		$app->get('/', function ()    {
			return "To do list service version 1";
		});
		
			date_default_timezone_set('Asia/Kolkata');
			$app->get('getbooks', 'BooksController@getAllBooks');
			$app->get('filter','BooksController@getFilterdlist');
			$app->put('rename/old/{oldtag}/new/{newtag}/tag','BooksController@renameTag');
			$app->post('addbook', 'BooksController@addBook');
			$app->delete('delete/{id}/book', 'BooksController@deleteBook');
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			});