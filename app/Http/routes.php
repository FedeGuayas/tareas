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

//obtener json con los eventos para todos los usuarios (calendario front-end y editable)
Route::get('getEvents{id?}',['uses'=>'EventController@index','as' => 'events.index'
]);

//obtener json con los eventos para el usuario logueado (calendario home)
Route::get('getUserEvents{id?}',['uses'=>'EventController@userEvents','as' => 'events.users.index'
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
//Route::get('/admin/tasks/users/{id}','AreasController@getUsers');//al subir al hosting 
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

        //mostrar comentarios
        Route::get('/tasks/{event}/comments/' ,['uses' => 'CommentController@getComment','as' => 'task.show.comment']);
        //cargar formulario para editar comentario
        Route::get('/tasks/edit/comment/{id}' ,['uses' => 'CommentController@edit','as' => 'task.edit.comment']);
        //guaradr comentario editado
        Route::put('/tasks/edit/comment/{id}' ,['uses' => 'CommentController@update','as' => 'task.update.comment']);
        //eliminar comentario editado
        Route::delete('/tasks/delete/comment/{id}' ,['uses' => 'CommentController@destroy','as' => 'task.delete.comment']);
        

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
        'uses'=>'ReportsController@indexUsersTask',
        'as'=>'admin.tasks.reports.users'
    ]);
        
    //exportar a excel reporte de un usuario
    Route::get('/tasks/reports/users/excel/',[
        'uses'=>'ReportsController@exportUsersTask',
        'as'=>'admin.tasks.reports.users.excel'
    ]);

    //cargar reportes de tareas generales por fecha
    Route::get('/tasks/reports/index/',[
        'uses'=>'ReportsController@indexTasks',
        'as'=>'admin.reports.index'
    ]);
    
    Route::get('/tasks/reports/excel/',[
        'uses'=>'ReportsController@exportTasks',
        'as'=>'admin.tasks.excel'
    ]);

    //cargar reportes de tareas pendientes por fecha
    Route::get('/tasks/reports/getPending/',[
        'uses'=>'ReportsController@getPending',
        'as'=>'admin.reports.getPending'
    ]);

    Route::get('/tasks/reports/exportPending/',[
        'uses'=>'ReportsController@exportPending',
        'as'=>'admin.reports.exportPending'
    ]);

    //cargar reportes de tareas terminada por fecha
    Route::get('/tasks/reports/getCompleted/',[
        'uses'=>'ReportsController@getCompleted',
        'as'=>'admin.reports.getCompleted'
    ]);

    Route::get('/tasks/reports/exportCompleted/',[
        'uses'=>'ReportsController@exportCompleted',
        'as'=>'admin.reports.exportCompleted'
    ]);


});


//asignar permisos a los roles
Route::get('rol/{id}/permisos', ['as' => 'admin.roles.permisos','uses'=>'RolesController@permisos' ]);
Route::PUT('rol/{id}/set-permisos', ['as' => 'admin.roles.setpermisos','uses'=>'RolesController@setPermisos' ]);

//adicionar roles a los usuarios
Route::get('user/{id}/roles', ['as' => 'admin.users.roles','uses'=>'UsersController@roles' ]);
Route::PUT('user/{id}/setroles', ['as' => 'admin.users.setroles','uses'=>'UsersController@setRoles' ]);
