<?php

Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

Route::get('planning', 'Planning\\PlanningController@requestPlanningGeneration');
Route::post('planning', 'Planning\\PlanningController@generatePlanningForAll');
Route::get('planning/{id}', 'Planning\\PlanningController@detailPlanning')->name('planning.merchandiser');
Route::post('pregenerate/planning/{id}', 'Planning\\PlanningController@preGeneratePlanning');
Route::post('pregenerate/planning', 'Planning\\PlanningController@preGeneratePlanningForAll');
Route::post('planning/{id}', 'Planning\\PlanningController@generatePlanning');
Route::get('paginate/planning', 'Planning\\PlanningController@paginateMerchandiser');
Route::get('download/planning/{id}', 'Planning\\PlanningController@downloadPlanning');
Route::post('upload/planning/{id}', 'Planning\\PlanningController@uploadPlanning');
Route::post('delete/planning', 'Planning\\PlanningController@deletePlanningForAll');
Route::post('delete/planning/{id}', 'Planning\\PlanningController@deletePlanning');