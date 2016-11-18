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



Route::auth();

//para activar cuenta de usuario por email
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');

Route::get('/home',['uses'=>'HomeController@index','as'=> 'home']);

Route::get('/', function(){
    return view('welcome');
});

//Calendario backend
Route::get('/callendar',function(){
    return view('callendar.index');
});

//obtener json con los eventos
Route::get('getEvents{id?}',['uses'=>'EventController@index','as' => 'events.index'
]);

//obtener json con datos para cargar en ventana modal en calendario
Route::post('/getDataModal{id?}',[
    'uses'=>'EventController@getDataModal',
    'as' => 'events.modal'
]);
//cargo calendario editable
Route::get('eventsEdit{task?}',[
    'uses'=>'EventController@edit',
    'as' => 'admin.calendar.edit'
]);
//actualizar eventos desde calendario
Route::post('actualizaEventos',[
    'uses'=>'EventController@update',
    'as' => 'events.update'
]);
//eliminar evento desde calendario
Route::post('eliminaEvento',[
    'uses'=>'EventController@destroy',
    'as'=>'events.delete'
]);



//obtener el id de las personas por area para select dinamico
Route::get('/users/{id}','AreasController@getUsers');



Route::group(['prefix'=>'user'],function(){

    //solo los autenticados pueden acceder al perfil y a deslogearse
    Route::group(['middleware'=>'auth'],function() {

        //acceso al perfil general de usuarios al hacer login
        Route::get('/profile', [ 'uses' => 'UsersController@getProfile','as' => 'user.profile' ]);

        //vista para editar la contraseña del perfil de usuario
        Route::get('/password/edit', ['uses' => 'UsersController@getPasswordEdit','as' => 'user.password.edit']);
        
        //actualizar la contraseña del perfil de usuario
        Route::put('{user}/profile/edit', ['uses' => 'UsersController@postPassword','as' => 'user.password.update']);
        
        //tareas del usuario
        Route::get('/tasks', ['uses' => 'UsersController@userTasks','as' => 'user.profile.tasks']);

        //cargar archivos y comentarios a un evento
        Route::get('/tasks/{id}/fileUpload', ['uses' => 'EventController@getFileUpload','as' => 'user.task.getFileUpload']);
        Route::post('/tasks/fileUpload', ['uses' => 'EventController@postFileUpload','as' => 'user.task.postFileUpload']);

        //descarga de archivos
        Route::get('/tasks/download/{file}' ,['uses' => 'EventController@downloadFile','as' => 'task.download.file']); 

        //el usuario solicita termino de tarea
        Route::post('/tasks/end-sol/{id?}', ['uses'=>'TaskController@userTaskEnd',
            'as'=>'user.task.end']);
        
        //el supervisor aprueba termino de tarea
        Route::post('/tasks/end-aprob/{id?}', ['uses'=>'TaskController@taskEndAprob',
            'as'=>'user.task.end.aprob']);
        
        //todas las notificaciones del usuarios
        Route::get('/notifications', ['uses'=>'NotificationController@getIndex','as'=>'user.notifications.all']);

        //ir a la url de la notificacion y marcarla como leida
        Route::get('/notifications{notification}', ['uses'=>'NotificationController@getRead','as'=>'user.notifications.read']);

        //eliminar una notificacion 
        Route::get('/notifications/{id}', ['uses'=>'NotificationController@notifyUserDelete','as'=>'user.notification.destroy']);
        
    });


});


Route::group(['prefix'=>'admin'],function() {

    Route::resource('/tasks', 'TaskController');
//    Route::resource('/persons', 'PersonsController');
    Route::resource('/areas', 'AreasController');
    Route::resource('/permissions', 'PermissionsController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/users', 'UsersController');
    Route::resource('/notifications', 'NotificationController');

    //cargar reportes de tareas por usuarios
    Route::get('/tasks/reports/users',[
        'uses'=>'ReportsController@index_users',
        'as'=>'admin.tasks.reports.users'
    ]);
    //buscar reportes de tareas por usuarios
    Route::post('/tasks/reports/users/{data?}',[
        'uses'=>'ReportsController@getUsersTask',
        'as'=>'admin.tasks.reports.users'
    ]);
    
    //exportar a excel reporte de un usuario
    Route::get('/tasks/reports/users/excel/',[
        'uses'=>'ReportsController@exportUsersTask',
        'as'=>'admin.tasks.reports.users.excel'
    ]);

    Route::get('/tasks/reports/index/',[
        'uses'=>'ReportsController@indexTasks',
        'as'=>'admin.reports.index'
    ]);
    
    Route::get('/tasks/reports/excel/',[
        'uses'=>'ReportsController@exportTasks',
        'as'=>'admin.tasks.excel'
    ]);



    
});


//asignar permisos a los roles
Route::get('rol/{id}/permisos', ['as' => 'admin.roles.permisos','uses'=>'RolesController@permisos' ]);
Route::PUT('rol/{id}/set-permisos', ['as' => 'admin.roles.setpermisos','uses'=>'RolesController@setPermisos' ]);

//adicionar roles a los usuarios
Route::get('user/{id}/roles', ['as' => 'admin.users.roles','uses'=>'UsersController@roles' ]);
Route::PUT('user/{id}/setroles', ['as' => 'admin.users.setroles','uses'=>'UsersController@setRoles' ]);
