<?php

use Illuminate\Support\Facades\Route;

/**
 * Registration routes.
 *
 */
Route::post('/register', 'RegistrationController@store')->name('register.store');
Route::get('/register/{enlist?}', 'RegistrationController@index')->name('register');

/**
 * Authentication routes.
 *
 */
Route::get('/login', 'LoginController@index')->name('login');
Route::get('/logout', 'LogoutController@index')->name('logout');
Route::post('/login', 'LoginController@store')->name('login.store');

/**
 * Email verification routes.
 *
 */
Route::post('/email/send', 'VerifyEmailController@store')->name('email.verify.send');
Route::get('/email/notice', 'VerifyEmailController@index')->name('email.verify.notice');
Route::get('/email/{id}/{hash}', 'VerifyEmailController@update')->name('email.verify.confirm');

/**
 * Password routes.
 *
 */
Route::post('/password', 'ChangePasswordController@update')->name('password.update');
Route::get('/password/forgot', 'ForgotPasswordController@index')->name('password.forgot');
Route::post('/password/forgot', 'ForgotPasswordController@store')->name('password.forgot.store');
Route::post('/password/reset', 'ResetPasswordController@store')->name('password.reset.store');
Route::get('/password/reset/{token}', 'ResetPasswordController@index')->name('password.reset');
