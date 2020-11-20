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

Route::group([], function () {
    Route::post('login', 'Api\AuthController@login');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::apiResource('users', 'Api\UserController');
        Route::apiResource('roles', 'Api\RoleController');
        Route::apiResource('modules', 'Api\ModuleController');
        Route::apiResource('tags', 'Api\RoleModuleTaggingController');
        Route::apiResource('brokers', 'Api\BrokerController');
        Route::apiResource('projects', 'Api\ProjectController');
        Route::apiResource('units', 'Api\UnitController');
        Route::apiResource('unittypes', 'Api\UnitTypeController');
        Route::apiResource('equitypercentages', 'Api\EquityPercentageController');
        Route::apiResource('monthstopay', 'Api\MonthsToPayController');
        Route::apiResource('prospects', 'Api\ProspectController');
        Route::apiResource('reservations', 'Api\ReservationController');
        Route::apiResource('processingdays', 'Api\ProcessingDayController');
        Route::apiResource('othercharges', 'Api\OtherChargeController');
        Route::apiResource('documents', 'Api\DocumentController');
        Route::apiResource('equities', 'Api\EquityController');
        Route::apiResource('equitiesbreakdown', 'Api\EquityBreakdownController');
        Route::apiResource('equitypayments', 'Api\EquityPaymentController');
        Route::apiResource('loantakeouts', 'Api\LoanTakeoutController');
        Route::apiResource('ewts', 'Api\EwtController');
        Route::apiResource('ctsfiles', 'Api\CtsFileController');

        Route::post('batch/users/delete', 'Api\UserController@destroyMany');
        Route::post('batch/roles/delete', 'Api\RoleController@destroyMany');
        Route::post('batch/unittypes/delete', 'Api\UnitTypeController@destroyMany');
        Route::post('batch/processingdays/delete', 'Api\ProcessingDayController@destroyMany');
        Route::post('batch/othercharges/delete', 'Api\OtherChargeController@destroyMany');
        Route::post('batch/projects/delete', 'Api\ProjectController@destroyMany');
        Route::post('batch/brokers/delete', 'Api\BrokerController@destroyMany');
        Route::post('batch/modules/delete', 'Api\ModuleController@destroyMany');
        Route::post('batch/prospects/delete', 'Api\ProspectController@destroyMany');
        Route::post('batch/units/delete', 'Api\UnitController@destroyMany');
        Route::post('batch/reservations/delete', 'Api\ReservationController@destroyMany');
        
        Route::patch('batch/{module}/{field}', 'Api\BatchController@update');

        Route::get('employees', 'Api\InnolandEmployeeController@index');
        Route::get('employees/{employee}', 'Api\InnolandEmployeeController@show');

        Route::get('search', 'Api\SearchController@result');

        Route::get('logout', 'Api\AuthController@logout');
        
    });
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact admin@innoland.com'], 404);
});