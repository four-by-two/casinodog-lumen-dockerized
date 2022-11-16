<?php
use Illuminate\Http\Request;

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('g', [
    'as' => 'casino.testingcontroller', 'uses' => '\App\Http\Controllers\Casinodog\Game\SessionsHandler@entrySession'
]);
// Available when debug mode is enabled to test method functions fast. {$function_name} should be the name of function in TestingController
$router->get('testing/{function_name}', [
    'as' => 'casino.testingcontroller', 'uses' => '\App\Http\Controllers\Casinodog\TestingController@handle'
]);

// API control routes
$router->group(['prefix' => 'api/control'], function () use ($router) {
    $router->post('parentsession/create', [
        'as' => 'casino.parentsession.create', 'uses' => '\App\Http\Controllers\Casinodog\API\ParentSessions\CreateParentSession@handle'
    ]);
    $router->get('parentsession/get', [
        'as' => 'casino.parentsession.get.bytoken', 'uses' => '\App\Http\Controllers\Casinodog\API\ParentSessions\GetParentSessionByToken@handle'
    ]);
});

// API games routes
$router->group(['prefix' => 'api/games'], function () use ($router) {
    // Catch all game API routes and send to the right place
    $router->get('{provider}/{internal_token}/{slug}/{action:.*}', function ($provider, $internal_token, $slug, $action, Request $request) use ($router) {
        return gameclass($provider)->game_event($request);
    });
    // Catch all game API routes and send to the right place
    $router->get('{provider}/{internal_token}/{action:.*}', function ($provider, $internal_token, $action, Request $request) use ($router) {
        return gameclass($provider)->game_event($request);
    });
    // Catch all game API routes and send to the right place
    $router->post('{provider}/{internal_token}/{slug}/{action:.*}', function ($provider, $internal_token, $slug, $action, Request $request) use ($router) {
        return gameclass($provider)->game_event($request);
    });
    // Catch all game API routes and send to the right place
    $router->post('{provider}/{internal_token}/{action:.*}', function ($provider, $internal_token, $action, Request $request) use ($router) {
        return gameclass($provider)->game_event($request);
    });
});