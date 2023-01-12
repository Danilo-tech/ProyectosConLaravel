<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use Illuminate\Support\Facades\Input;


//Web
Route::get('/', 'WelcomeController@index');
Route::get('/sobre', 'WelcomeController@sobre');
Route::get('/la-guarderia', 'WelcomeController@laGuarderia');
Route::get('/faq', 'WelcomeController@faq');
Route::get('/contacto', 'WelcomeController@contacto');
Route::get('/gateadores', 'WelcomeController@gateadores');
Route::get('/caminantes', 'WelcomeController@caminantes');
Route::get('/toddlers', 'WelcomeController@toddlers');
Route::get('/pre-escolares', 'WelcomeController@preEscolares');
Route::post('/send-mail', 'WelcomeController@contactoSend');

// parte del Administrador
Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
// Administrador
Route::group(['prefix'=>'editor', 'middleware'=>['auth'], 'namespace'=>'Editor'], function(){
    Route::group(['prefix'=>'altura','namespace'=>'Altura'], function(){
        Route::resource('catblog', 'CatBlogController');
        Route::resource('multimediablog', 'MultimediaBlogController');
        Route::get('tabla-traductor/{id}/{language}/{operacion}/{modelo}', ['as' => 'tabla-traductor', 'uses' => 'CatBlogController@traductor'] );
        Route::get('create-elemento-cb/{idprincipal}/{idsecundario}/{model}', ['as' => 'create-elemento-cb', 'uses' => 'CatBlogController@createcb'] );
        Route::get('delete-elemento-cb/{idprincipal}/{idsecundario}/{model}', ['as' => 'delete-elemento-cb', 'uses' => 'CatBlogController@deletecb'] );
        Route::post('update-cantidad-tabla', ['as' => 'update-cantidad-tabla', 'uses' => 'CatBlogController@updatecantidad'] );
    });
});

