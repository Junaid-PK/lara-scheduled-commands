<?php

use App\Models\UserLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/worktime/get', function(){
    $userlog = UserLog::all();
    // $userlog = UserLog::select(
    //     DB::raw('user_id'),
    //     DB::raw('DATE(checked_in_at) AS work_date'),
    //     DB::raw('SUM(TIMESTAMPDIFF(HOUR, checked_in_at, checked_out_at)) AS total_hours_worked')
    // )
    // ->groupBy('user_id', 'work_date')
    // ->get();
    return $userlog;
});
