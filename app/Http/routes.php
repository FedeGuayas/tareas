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

Route::get('/home',[
    'uses'=>'HomeController@index',
    'as'=> 'home'
    ]);

Route::get('/', function(){
    return view('welcome');
});

//Route::get('/',function(){
//    return view('welcome');
//});


//obtener el id de las personas por area
Route::get('/persons/{id}','AreasController@getPersons');



Route::group(['prefix'=>'admin'],function() {

    Route::resource('/tasks', 'TaskController');
    Route::resource('/persons', 'PersonsController');
    Route::resource('/areas', 'AreasController');
});



//    //middleware para los k no estan autenticado
//    Route::group(['middleware'=>'guest'],function() {
//
//        //cargar el form para login
//        Route::get('/signin', [
//            'uses' => 'UsersController@getSignin',
//            'as' => 'user.signin'
//        ]);
//
//        //enviar datas del form de login
//        Route::post('/signin', [
//            'uses' => 'UsersController@postSignin',
//            'as' => 'user.signin'
//        ]);
//    });

    //solo los autenticados pueden acceder al perfil y a deslogearse
    Route::group(['middleware'=>'auth'],function() {

        //acceso al perfil de usuarios
//        Route::get('/profile', [
//            'uses' => 'UsersController@getProfile',
//            'as' => 'user.profile'
//        ]);
//
//        //salir del sistema
//        Route::get('/logout', [
//            'uses' => 'UsersController@getLogout',
//            'as' => 'user.logout'
//        ]);
    });




//Eventos Calendario
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



//Calendario Task

Route::get('/getTasks{id?}',[
    'uses'=>'TaskController@getTasks',
    'as' => 'task.show'
]);

Route::post('/getDataModal{id?}',[
    'uses'=>'TaskController@getDataModal',
    'as' => 'callendar.person'
]);









Route::group(['prefix'=>'user'],function(){

    //middleware para los k no estan autenticado
    Route::group(['middleware'=>'guest'],function() {
        
        //cargar el form para login
        Route::get('/signin', [
            'uses' => 'UsersController@getSignin',
            'as' => 'user.signin'
        ]);

        //enviar los datos datas del form de login 
        Route::post('/signin', [
            'uses' => 'UsersController@postSignin',
            'as' => 'user.signin'
        ]);
    });

    //solo los autenticados pueden acceder al perfil y a deslogearse
    Route::group(['middleware'=>'auth'],function() {

        //acceso al perfil de usuarios
        Route::get('/profile', [
            'uses' => 'UsersController@getProfile',
            'as' => 'user.profile'
        ]);

        //salir del sistema
        Route::get('/', [
            'uses' => 'UsersController@getLogout',
            'as' => 'user.logout'
        ]);
    });


});