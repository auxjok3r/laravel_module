<?php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['web', 'localeSessionRedirect', 'localizationRedirect'],
    'namespace' => 'Icorebiz\ModuleName\Http\Controllers'
], function () {
    Route::group(['middleware' => 'auth'], function () {
		//add routes here
    });
});




