<?php

/**
 * Frontend Controllers
 */

/**
 * These frontend controllers require the user to be logged in
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User'], function () {


        /* new routes */
        Route::group(['middleware' => 'access.routeNeedsPermission:view-frontend'], function () {
            Route::group(['middleware' => 'access.routeNeedsPermission:edit-visits'], function () {
                Route::get('/network/add/{type}', 'NetworkController@create');
                Route::post('/network/add/{type}', 'NetworkController@store');
                Route::get('/network/edit/{type}/{id}', 'NetworkController@edit');
                Route::post('/network/edit/{type}/{id}', 'NetworkController@update');

                Route::get('/ilv/add', 'ILVController@create');
                Route::post('/ilv/add', 'ILVController@store');
                Route::get('/ilv/edit/{id}', 'ILVController@edit');
                Route::post('/ilv/edit/{id}', 'ILVController@update');

                Route::get('/appro/edit/{id}', 'StockController@paginate');
                Route::get('/appro/delete/{id}', 'StockController@destroy');
                Route::post('/appro/add/{id}', 'StockController@add');
                Route::post('/appro/edit/', 'StockController@edit');


                Route::get('/service/note/add', 'CommentController@create');
                Route::post('/service/note/add', 'CommentController@addServiceNote');
                Route::post('/note/visits/{id}', 'CommentController@addNoteForVisit');
                Route::post('/comment/visits/', 'CommentController@addCommentForVisit');
                Route::post('/note/pictures/', 'CommentController@addNoteForPicture');
                Route::post('/comment/pictures/', 'CommentController@addCommentForPicture');
                Route::post('/note/answer/{id}', 'CommentController@addNoteForAnswer');
                Route::post('/comment/answer/{id}', 'CommentController@addCommentForAnswer');


                //GuideLine Routes
                Route::get('/guideline/add', 'DocumentController@guidelineCreate');
                Route::post('/guideline/add', 'DocumentController@guidelineStore');
                Route::get('/guideline/edit/{id}', 'DocumentController@guidelineEdit');
                Route::post('/guideline/edit/{id}', 'DocumentController@guidelineUpdate');
                Route::get('/guideline/delete/{id}', 'DocumentController@guidelineDelete');
                Route::get('/guideline/destroy/{id}', 'DocumentController@guidelineDestroy');

                //Technic Files Routes
                Route::get('/technic_file/add', 'DocumentController@technicFileCreate');
                Route::post('/technic_file/add', 'DocumentController@technicFileStore');
                Route::get('/technic_file/edit/{id}', 'DocumentController@technicFileEdit');
                Route::post('/technic_file/edit/{id}', 'DocumentController@technicFileUpdate');
                Route::get('/technic_file/delete/{id}', 'DocumentController@technicFileDelete');
                Route::get('/technic_file/destroy/{id}', 'DocumentController@technicFileDestroy');


                //Task Routes
                Route::get('/tasks', 'TaskController@index');
                Route::get('/tasks/paginate', 'TaskController@paginate');
                Route::get('/tasks/details/{id}', 'TaskController@show');
                Route::get('/tasks/add', 'TaskController@create');
                Route::post('/tasks/add', 'TaskController@store');
                Route::get('/tasks/edit/{id}', 'TaskController@edit');
                Route::post('/tasks/edit/{id}', 'TaskController@update');
                Route::post('/tasks/delete/{id}', 'TaskController@destroy');

                //Statistics
                Route::get('/checklists', 'StatsController@checklists')->name('stats.checklists');
                Route::get('/checklists/{type}', 'StatsController@searchForChecklists')->name('paginate.checklists');
                Route::get('/checklists/stats/{id}', 'StatsController@checklist')->name('stats.details.checklists');
                Route::get('/stats/checklist/{id}', 'StatsController@statsOnChecklist')->name('stats.on.checklist');
                Route::get('/visites', 'StatsController@visites')->name('stats.visits');
                Route::get('/stats/visits', 'StatsController@searchForVisits')->name('ajax.stats.visits');
                Route::get('/merchandiser', 'StatsController@merchandiser');
                Route::get('/paginate/merchandiser', 'StatsController@paginateMerchandisers')->name('paginate.merchandiser');
                Route::get('/merchandiser/{id}', 'StatsController@profile')->name('profile.merchandiser');
                Route::get('/networks', 'StatsController@network')->name('stats.networks');
                Route::get('/networks/paginate/{type}', 'StatsController@paginateNetworks')->name('stats.networks.paginate');
                Route::get('/zone/governorate', 'StatsController@getDelegationPerZone')->name('zones.governorate');
                Route::get('/zones/list', 'StatsController@getZones')->name('zones');

            });
            Route::group(['middleware' => 'access.routeNeedsPermission:view-visits'], function () {
                //Dashboard
                Route::get('dashboard', 'DashboardController@index')->name('frontend.user.dashboard');
                Route::get('profile/edit', 'ProfileController@edit')->name('frontend.user.profile.edit');
                Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
                //Visits Web
                Route::get('visits/{type}', 'VisitController@index');
                Route::get('/ilv_network/paginate/{id}', 'ILVController@paginateHistory');
                Route::get('/ilv_network/paginateILVPerNetwork/{id}', 'ILVController@paginateILVPerNetwork');
                /*Route::get('visits/add', 'VisitController@create');
                Route::post('visits/add', 'VisitController@store');
                Route::get('visits/edit/{id}', 'VisitController@edit');
                Route::post('visits/edit/{id}', 'VisitController@update');
                Route::get('visits/delete/{id}', 'VisitController@destroy');*/

                Route::get('lastvisits/{type}/{id}', 'LastVisitController@show');

                //Networks Routes
                Route::get('/network/list/{type}/', 'NetworkController@index');
                Route::get('/network/detail/{type}/{id}', 'NetworkController@show');
                Route::get('/network/paginate/{type}', 'NetworkController@paginate');
                Route::get('/network/history/{id}', 'NetworkController@getVisitsPerNetwork')->name('network.history.paginate');
                Route::get('/autocomplete/networks', 'NetworkController@networkAutoComplete')->name('autocomplete.networks');


                //Cities Routes
                Route::post('/city/find/', 'CityController@getCityByName');


                Route::get('/merch', function () {
                    return view('frontend/dashboard/dashboard-merch');
                });
                Route::get('/visitilv', function () {
                    return view('frontend/ilv/add');
                });
                Route::get('/alerts', 'AlertController@index');

                //Routes For ILV
                Route::get('/ilv', 'ILVController@index');
                Route::get('/ilv/paginate', 'ILVController@paginate');
                Route::get('/ilv/detail/{id}', 'ILVController@show');
                Route::get('/ilv/stats/{id}', 'ILVController@ilvStats')->name('ilv.stats.availability');
                Route::get('/ilv/deactivate/{id}', 'ILVController@deactivate')->name('ilv.deactivate');

                //Routes For Approvisionnement
                Route::get('/appro/paginate/{id}', 'StockController@paginate');

                /*Route::get('/task', function () {
                    return view('frontend/task/list');
                });
                Route::get('/task/detail', function () {
                    return view('frontend/task/detail');
                });*/
                Route::get('/setting', function () {
                    return view('frontend/setting/view');
                });
            });


            Route::get('planning', 'VisitController@getPlanning');
            Route::get('pagination', 'VisitController@paginate');
            Route::get('/pagination_visits/{type}', 'VisitController@paginateVisits');


            Route::get('/mydaily', 'VisitController@myDailyVisit');
            Route::get('/getmydaily', 'VisitController@getTodayVisits');
            Route::get('visits/{type}/{id}', 'VisitController@show');
            //Answers Web
            //Route::get('answers/', 'AnswerController@index');
            Route::group(['middleware' => 'access.routeNeedsPermission:add-visits'], function () {
                Route::get('answers/add/{id}', 'AnswerController@create');
                Route::post('answers/add/{id}', 'AnswerController@store');

                Route::get('visits/ilv/add/{id}', 'VisitController@createIlvVisit');
                Route::post('visits/ilv/add/{id}', 'VisitController@storeIlvVisit');
                Route::get('visits/ilv/edit/{id}', 'VisitController@editIlvVisit');
                Route::post('visits/ilv/edit/{id}', 'VisitController@updateIlvVisit');

                //Branding ans display Photos
                Route::get('/photos/add/{type}/{id}', 'PhotoController@create');
                Route::post('/photos/add/{type}/{id}', 'PhotoController@store');
            });
            Route::get('answers/edit/{id}', 'AnswerController@edit');
            Route::post('answers/edit/{id}', 'AnswerController@update');


            Route::get('/chat', 'MessageController@index');
            Route::post('/chat/send_message', 'MessageController@send');
            Route::post('/chat/get_messages', 'MessageController@getMessages');
            //Comments and notes Routes
            Route::post('/comment/visits/', 'CommentController@addCommentForVisit');
            Route::post('/comment/pictures/', 'CommentController@addCommentForPicture');
            Route::post('/comment/answer/{id}', 'CommentController@addCommentForAnswer');

            //Service Notes
            Route::get('/service/note/', 'CommentController@index');
            Route::get('/service/note/edit/{id}', 'CommentController@edit');
            Route::post('/service/note/edit/{id}', 'CommentController@update');
            Route::get('/service/note/delete/{id}', 'CommentController@delete');
            Route::get('/service/note/destroy/{id}', 'CommentController@destroy');

            Route::get('/service/note/{id}', 'CommentController@show');
            Route::get('/service/notes/', 'CommentController@getNotes');
            Route::get('branding/add', function () {
                return view('frontend/branding/add');
            });

            //GuideLine Routes
            Route::get('/guideline', 'DocumentController@guidelineIndex');
            Route::get('/guidelines/paginate', 'DocumentController@guidelinePaginate');
            Route::get('/guideline/{id}', 'DocumentController@guidelineShow');
            Route::get('/guideline/download/{id}', 'DocumentController@guidelineDownload');

            //Technic Files Routes
            Route::get('/technic_file', 'DocumentController@technicFileIndex');
            Route::get('/technic_files/paginate', 'DocumentController@technicFilePaginate');
            Route::get('/technic_file/{id}', 'DocumentController@technicFileShow');
            Route::get('/technic_file/download/{id}', 'DocumentController@technicFileDownload');


        });


    });
    Route::get('/', 'FrontendController@index')->name('frontend.index');
    Route::get('macros', 'FrontendController@macros')->name('frontend.macros');


});

