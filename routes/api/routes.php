<?php
Route::group(
    [
        'prefix'        => 'auth',
        'namespace'     => 'App\Http\Controllers\API',
        // 'middleware'    => ['multiLingual']
    ],
    function () {
        Route::post('/register', 'AuthController@register');
        Route::post('/login', 'AuthController@login');
    }
);

Route::group(
    [
        'prefix' => 'user',
        'namespace' => 'App\Http\Controllers\API',
        'middleware' => ['auth:api'],
    ],
    function () {
        Route::get('/settings', 'UserSettingsController@settings');
    }
);

Route::group(
    [
        'prefix' => 'settings',
        'namespace' => 'App\Http\Controllers\API',
        'middleware' => ['auth:api'],
    ],
    function () {
        Route::get('/get-sources-dropdown', 'UserSettingsController@getSources');
        Route::get('/get-catagories-dropdown', 'UserSettingsController@getCatagories');
        Route::post('/save-user-settings', 'UserSettingsController@saveUserSettings');
    }
);

Route::group(
    [
        'prefix' => 'feed',
        'namespace' => 'App\Http\Controllers\API',
        'middleware' => ['auth:api'],
    ],
    function () {
        Route::get('/get-feed', 'ArticlesFeedController@getArticlesFeed');
    }
);

?>