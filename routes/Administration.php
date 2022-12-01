<?php

use Illuminate\Support\Facades\Route;

/**
 * Dashboard routes.
 *
 */
Route::get('/dashboard/admin', 'DashboardController@index')->name('dashboard.admin');

/**
 * Tool routes.
 *
 */
Route::get('/tools', 'ToolController@index')->name('tools');
Route::post('/tools', 'ToolController@store')->name('tools.store');
Route::post('/tools/search', 'ToolController@search')->name('tools.search');
Route::patch('/tools/{tool}', 'ToolController@update')->name('tools.update');
Route::delete('/tools/{tool}', 'ToolController@delete')->name('tools.delete');
