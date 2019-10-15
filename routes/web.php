<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});

Route::post('/login','HomeController@login')->name('login');
Route::post('/register','HomeController@register')->name('register');
Route::get('/dashboard','HomeController@dashboard')->name('dashboard');
Route::get('/addTeacher','HomeController@teacher')->name('teacher');
Route::post('/addTeacher','HomeController@addTeacher')->name('addTeacher');
Route::get('/student','HomeController@student')->name('student');
Route::post('/addStudent','HomeController@addStudent')->name('addStudent');


