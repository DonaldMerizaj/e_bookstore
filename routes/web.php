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
    return view('backend.login');
})->name('loginView');

Route::get('/register', function () {
    return view('backend.register');
})->name('register');

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

// home page
Route::post('/login', 'UserController@login')->name('login');
Route::post('/signup', 'UserController@register')->name('signup');


Route::group(['middleware'=> 'isLogged'], function (){
//    Route::get('/dashboard', 'UserController@index')->name('dashboard');
    Route::get('/dashboard/librat', 'LibriController@index')->name('listLibrat');
    Route::get('/dashboard/librat/krijo', 'LibriController@create')->name('krijoLiber');
    Route::post('/dashboard/librat/krijo/ruaj', 'LibriController@ruaj')->name('ruajLiber');
    Route::get('/dashboard/librat/edito/{id}', 'LibriController@edit')->name('editLibri');
    Route::post('/dashboard/librat/edito/update', 'LibriController@update')->name('updateLiber');
    Route::post('/dashboard/librat/edito/fshi', 'LibriController@fshi')->name('fshiLibri');

    Route::group(['middleware'=> 'isPunonjes'], function () {

        Route::get('/dashboard/users', 'LibriController@index')->name('listUsers');

        Route::get('/dashboard/klient', 'KlientController@index')->name('listKlient');

        Route::post('/dashboard/klient/shiko/kthe', 'LibriController@kthe')->name('ktheLibri');

        Route::post('/dashboard/zhaner/fshi', 'ZhanriController@fshi')->name('fshiZhaner');

        Route::get('/dashboard/zhaner', 'ZhanriController@view')->name('viewZhaner');

        Route::get('/dashboard/mesazhe', 'UserController@viewAllMsg')->name('viewallmsg');
        Route::post('/dashboard/mesazhe/fshi', 'UserController@fshiMsg')->name('fshiMsg');

        Route::post('/dashboard/zhaner/krijo', 'ZhanriController@save')->name('save_zhaner');

        Route::get('/dashboard/raporte', 'InventarController@raporte')->name('listRaporte');

        Route::get('/dashboard/autore', 'AutorController@view')->name('viewAutor');
        Route::post('/dashboard/autore/fshi', 'AutorController@delete')->name('fshiAutor');
        Route::post('/dashboard/autore/save', 'AutorController@save')->name('saveAutor');

        Route::post('/feedback/all', 'KlientController@viewAllMsg')->name('viewMsgAll');
    });

    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::post('/card/save', 'CardController@save')->name('add_card');
    Route::get('/card', 'CardController@view')->name('view_card');
    Route::post('/card/fshi', 'CardController@fshi')->name('fshi_card');

    Route::get('/feedback', 'KlientController@krijomsg')->name('krjomsg');
    Route::post('/feedback/save', 'KlientController@ruajmsg')->name('ruajmsg');

});
