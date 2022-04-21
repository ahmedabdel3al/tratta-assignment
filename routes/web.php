<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function (\Illuminate\Http\Request $request) {
    return \Illuminate\Support\Facades\Cache::remember('remember',60 * 60, function () use ($request) {
        return \Facades\App\Services\Communication\Manager::make('twilio')
            ->getUsageRecords('AC977a3102fe6a45dd7dd2b70895049f7f', '2022-01-01', '2022-01-31',
                [
                    'calls_inbound_fee' => $request->get('calls_inbound_fee'),
                    'sms_inbound_longcode_fee' => $request->get('sms_inbound_longcode_fee'),
                ]
            );
    });

});
