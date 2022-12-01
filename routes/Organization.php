<?php

use Illuminate\Support\Facades\Route;

/**
 * Organization routes.
 *
 */
Route::get('/organization', 'OrganizationController@index')->name('organization');
Route::post('/organization', 'OrganizationController@store')->name('organization.store');
Route::patch('/organization', 'OrganizationController@update')->name('organization.update');
Route::delete('/organization', 'OrganizationController@delete')->name('organization.delete');
Route::get('/organization/create', 'OrganizationController@create')->name('organization.create');

/**
 * Member routes.
 *
 */
Route::get('/members', 'MemberController@index')->name('members');
Route::post('/members', 'MemberController@store')->name('members.store');
Route::patch('/members/{member}', 'MemberController@update')->name('members.update');
Route::delete('/members/{member}', 'MemberController@delete')->name('members.delete');

/**
 * Vacancy routes.
 *
 */
Route::get('/vacancies', 'VacancyController@index')->name('vacancies');
Route::post('/vacancies', 'VacancyController@store')->name('vacancies.store');
Route::get('/vacancies/create', 'VacancyController@create')->name('vacancies.create');
Route::get('/vacancies/{vacancy}', 'VacancyController@show')->name('vacancies.show');
Route::get('/vacancies/{vacancy}/edit', 'VacancyController@edit')->name('vacancies.edit');
Route::patch('/vacancies/{vacancy}', 'VacancyController@update')->name('vacancies.update');
Route::delete('/vacancies/{vacancy}', 'VacancyController@delete')->name('vacancies.delete');
Route::get('/vacancies/{vacancy}/export', 'VacancyController@export')->name('vacancies.export');
Route::patch('/vacancies/{vacancy}/archive', 'VacancyController@archive')->name('vacancies.archive');

/**
 * Requirement routes.
 *
 */
Route::post('/requirements/{vacancy}', 'RequirementController@store')->name('requirements.store');
Route::patch('/requirements/{requirement}', 'RequirementController@update')->name('requirements.update');
Route::delete('/requirements/{requirement}', 'RequirementController@delete')->name('requirements.delete');

/**
 * Invitation routes.
 *
 */
Route::post('/invitations/{vacancy}/bulk', 'InvitationController@bulk')->name('invitations.bulk');
Route::post('/invitations/{vacancy}/{user}', 'InvitationController@store')->name('invitations.store');
