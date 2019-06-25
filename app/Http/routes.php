<?php

Route::group(['middleware' => 'web'], function () {
    /**
     * Switch between the included languages
     */
    Route::group(['namespace' => 'Language'], function () {
        require(__DIR__ . '/Routes/Language/Language.php');
    });

    /**
     * Frontend Routes
     * Namespaces indicate folder structure
     */
    Route::group(['namespace' => 'Frontend'], function () {
        require(__DIR__ . '/Routes/Frontend/Frontend.php');
        require(__DIR__ . '/Routes/Frontend/Access.php');
    });

});

/**
 * Backend Routes
 * Namespaces indicate folder structure
 * Admin middleware groups web, auth, and routeNeedsPermission
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    /**
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    require(__DIR__ . '/Routes/Backend/Dashboard.php');
    require(__DIR__ . '/Routes/Backend/Access.php');
    require(__DIR__ . '/Routes/Backend/LogViewer.php');

});
Route::group(['namespace' => 'API', 'prefix' => 'api'], function () {
    /*Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);*/
    Route::post('authenticate', 'AuthenticateController@authenticate');

    //Visits API
    Route::get('visits/all', 'VisitAPIController@getVisitsByUser');
    Route::post('visits/bydate', 'VisitAPIController@getVisitsByUserByDate');
    Route::post('answers/add', 'VisitAPIController@addAnswer');
    Route::post('photos/add', 'VisitAPIController@addPhoto');
    Route::post('photos/addjson', 'VisitAPIController@addPhotoJson');

    //Cities API
    Route::get('cities', 'CityAPIController@getCities');

    //Networks API
    Route::get('networks/types', 'NetworkAPIController@getNetworkTypes');
    Route::get('networks/all', 'NetworkAPIController@getNetworks');
    Route::get('networks/franchises', 'NetworkAPIController@getFranchises');
    Route::get('networks/pdvs', 'NetworkAPIController@getPDVs');

    //Checklists API
    Route::get('checklists/taskcats', 'ChecklistAPIController@getTaskCats');
    Route::get('checklists/tasksubcats', 'ChecklistAPIController@getTaskSubCats');
    Route::get('checklists/tasks', 'ChecklistAPIController@getTasks');
    Route::get('checklists/all', 'ChecklistAPIController@getChecklists');
    Route::get('checklists/photocats', 'ChecklistAPIController@getPhotoCats');

});

Route::group(['namespace' => 'API\\v2', 'prefix' => 'api/v2'], function () {
    Route::post('authenticate', 'AuthenticateController@authenticate');
    //Answer with photos
    Route::post('answers/add', 'VisitAPIController@addAnswerWithPhotos');
    Route::post('answers/add/byone', 'VisitAPIController@addAnswer');
    Route::post('answers/add/verify', 'VisitAPIController@verifyAnswer');
    Route::post('photos/add/byone', 'PhotoAPIController@addPhoto');
    Route::post('photos/add/verify', 'PhotoAPIController@verifyPhotos');
    Route::post('visits/add/comment', 'VisitAPIController@addVisitComment');
    Route::get('photos/download/{id}', 'PhotoAPIController@getPhoto');

    //Messaging
    Route::get('users/all', 'MessageAPIController@getUsers');
    Route::get('messages/all', 'MessageAPIController@getMyMessages');
    Route::post('messages/add', 'MessageAPIController@addMessage');
    Route::post('messages/seen', 'MessageAPIController@addMessageSeen');

    Route::get('notes/service/all', 'MessageAPIController@getNotesService');
    Route::post('notes/service/seen', 'MessageAPIController@addNoteSeen');
    Route::get('notes/superviseur/all', 'MessageAPIController@getNotesSuperviseur');
    Route::post('notes/superviseur/details', 'MessageAPIController@getNoteDetails');

    //Documents
    Route::get('documents/guidelines/all', 'DocumentAPIController@getGuidelines');
    Route::get('documents/fiches/all', 'DocumentAPIController@getFichesTechniques');
    Route::post('documents/guidelines/seen', 'DocumentAPIController@addGuidelineSeen');
    Route::post('documents/fiches/seen', 'DocumentAPIController@addFicheTechniqueSeen');

    //GCM
    Route::post('devices/register', 'GcmAPIController@registerDevice');
    Route::get('devices/test', 'GcmAPIController@sendTestPush');

    //ILV
    Route::get('ilvs/all', 'ILVAPIController@getILVList');
    Route::post('ilvs/add', 'ILVAPIController@addILVVisit');
    
});
