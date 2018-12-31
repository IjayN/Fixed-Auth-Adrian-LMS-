<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

require __DIR__ . '/auth/auth.php';
require __DIR__ . '/auth/passwordReset.php';

Route::post('/applyLeave/{id}', 'LeaveController@applyLeave');
Route::get('/department_employees/{id}', 'LeaveController@employees_departments');
Route::get('/employees', 'LeaveController@employees');
Route::get('/leaveHistory/{id}', 'LeaveController@leaveHistory');
// Route::get('/calculateLeave/{id}', 'LeaveController@calculate_days');
Route::get('/send/email', 'LeaveController@mail');
