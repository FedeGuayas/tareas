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


//Eventos FULLCalendario
//Route::get('/verEventos',function(){
//    return view('tasks.eventos');
//});
//
//Route::post('/guardaEventos', [
//    'uses' => 'CalendarController@create',
//    'as' => 'guardaEventos'
//]);
//
//Route::get('/cargaEventos{id?}',[
//        'uses'=>'CalendarController@index',
//        'as' => 'cargaEventos'
//]);
//
//Route::post('/actualizaEventos','CalendarController@update');
//Route::post('eliminaEvento','CalendarController@delete');



/*OKKKKKKKKKKKKKKKK*/


Route::group(['prefix'=>'user'],function(){

    //solo los autenticados pueden acceder al perfil y a deslogearse
    Route::group(['middleware'=>'auth'],function() {

        //acceso al perfil de usuarios
        Route::get('/profile', [
            'uses' => 'UsersController@getProfile',
            'as' => 'user.profile'
        ]);
        
    });


});

Route::auth();

//para activar cuenta de usuario por email
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');

Route::get('/home',['uses'=>'HomeController@index','as'=> 'home']);

Route::get('/', function(){
    return view('welcome');
});


//Calendario
Route::get('/callendar',function(){
    return view('callendar.index');
});

Route::get('getTasks{id?}',[
    'uses'=>'TaskController@getTasks',
    'as' => 'task.show'
]);

Route::post('/getDataModal{id?}',[
    'uses'=>'TaskController@getDataModal',
    'as' => 'task.person'
]);


//obtener el id de las personas por area
Route::get('/persons/{id}','AreasController@getPersons');


Route::group(['prefix'=>'admin'],function() {

    Route::resource('/tasks', 'TaskController');
    Route::resource('/persons', 'PersonsController');
    Route::resource('/areas', 'AreasController');

});

