<?php

use Illuminate\Support\Facades\Route;

/**
 * Home routes.
 *
 */
Route::get('/', 'HomeController@index')->name('home');

/**
 * Employer routes.
 *
 */
Route::get('/employers', 'EmployerController@index')->name('employers');

/**
 * Legal routes.
 *
 */
Route::get('/legal', 'LegalController@index')->name('legal');

/**
 * Support routes.
 *
 */
Route::get('/support', 'SupportController@index')->name('support');

/**
 * Guide routes.
 *
 */
Route::get('/guide/{page?}', 'GuideController@index')->name('guide');

/**
 * Image routes.
 *
 */
Route::post('/images', 'ImageController@store')->name('images.store');
