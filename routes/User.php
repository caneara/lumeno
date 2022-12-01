<?php

use Illuminate\Support\Facades\Route;

/**
 * Dashboard routes.
 *
 */
Route::get('/dashboard/user', 'DashboardController@index')->name('dashboard.user');

/**
 * Account routes.
 *
 */
Route::get('/account', 'AccountController@edit')->name('account.edit');
Route::patch('/account', 'AccountController@update')->name('account.update');
Route::delete('/account', 'AccountController@delete')->name('account.delete');
Route::get('/@{user:handle}', 'AccountController@show')->name('account.show');

/**
 * Avatar routes.
 *
 */
Route::patch('/avatar', 'AvatarController@update')->name('avatar.update');

/**
 * Skill routes.
 *
 */
Route::get('/skills', 'SkillController@index')->name('skills');
Route::post('/skills', 'SkillController@store')->name('skills.store');
Route::post('/skills/setup', 'SkillController@setup')->name('skills.setup');
Route::patch('/skills/{skill}', 'SkillController@update')->name('skills.update');
Route::delete('/skills/{skill}', 'SkillController@delete')->name('skills.delete');

/**
 * School routes.
 *
 */
Route::get('/schools', 'SchoolController@index')->name('schools');
Route::post('/schools', 'SchoolController@store')->name('schools.store');
Route::patch('/schools/{school}', 'SchoolController@update')->name('schools.update');
Route::delete('/schools/{school}', 'SchoolController@delete')->name('schools.delete');

/**
 * Workplace routes.
 *
 */
Route::get('/workplaces', 'WorkplaceController@index')->name('workplaces');
Route::post('/workplaces', 'WorkplaceController@store')->name('workplaces.store');
Route::patch('/workplaces/{workplace}', 'WorkplaceController@update')->name('workplaces.update');
Route::delete('/workplaces/{workplace}', 'WorkplaceController@delete')->name('workplaces.delete');

/**
 * Project routes.
 *
 */
Route::get('/projects', 'ProjectController@index')->name('projects');
Route::post('/projects', 'ProjectController@store')->name('projects.store');
Route::get('/projects/create', 'ProjectController@create')->name('projects.create');
Route::get('/projects/{project}/edit', 'ProjectController@edit')->name('projects.edit');
Route::patch('/projects/{project}', 'ProjectController@update')->name('projects.update');
Route::delete('/projects/{project}', 'ProjectController@delete')->name('projects.delete');

/**
 * Article routes.
 *
 */
Route::get('/articles', 'ArticleController@index')->name('articles');
Route::post('/articles', 'ArticleController@store')->name('articles.store');
Route::get('/articles/create', 'ArticleController@create')->name('articles.create');
Route::get('/articles/{article}/edit', 'ArticleController@edit')->name('articles.edit');
Route::patch('/articles/{article}', 'ArticleController@update')->name('articles.update');
Route::delete('/articles/{article}', 'ArticleController@delete')->name('articles.delete');
Route::get('/articles/{article}/{slug?}', 'ArticleController@show')->name('articles.show');
