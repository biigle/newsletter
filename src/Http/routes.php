<?php

$router->group([
    'namespace' => 'Api',
    'prefix' => 'api/v1',
    'middleware' => ['api', 'auth:web,api'],
], function ($router) {
    $router->resource('newsletters', 'NewsletterController', [
        'only' => ['store', 'update', 'destroy'],
        'parameters' => ['newsletters' => 'id'],
    ]);

    $router->post('newsletters/{id}/publish', [
        'uses' => 'NewsletterController@publish',
    ]);

    $router->resource('newsletter-subscribers', 'NewsletterSubscriberController', [
        'only' => ['destroy'],
        'parameters' => ['newsletter-subscribers' => 'id'],
    ]);
});

$router->group([
    'namespace' => 'Views',
], function ($router) {
    $router->group([
        'prefix' => 'admin',
        'middleware' => ['auth:web', 'can:sudo'],
    ], function ($router) {
        $router->get('newsletter', [
           'uses' => 'AdminController@index',
           'as' => 'newsletter.admin.index',
        ]);

        $router->get('newsletter/create', [
           'uses' => 'AdminController@create',
           'as' => 'newsletter.admin.create',
        ]);

        $router->get('newsletter/{id}/edit', [
           'uses' => 'AdminController@edit',
           'as' => 'newsletter.admin.edit',
        ]);
    });

    $router->get('newsletter', [
       'uses' => 'NewsletterController@index',
    ]);

    $router->post('newsletter/subscribe', [
       'uses' => 'NewsletterController@create',
    ]);

    $router->get('newsletter/show/{id}', [
       'uses' => 'NewsletterController@show',
       'as' => 'newsletter.show',
    ]);

    $router->get('newsletter/verify', [
       'uses' => 'NewsletterController@created',
    ]);

    $router->get('newsletter/verify/{id}/{hash}', [
        'uses' => 'NewsletterController@verify',
        'middleware' => ['signed'],
        'as' => 'newsletter.verify',
    ]);

    $router->get('newsletter/subscribed', [
       'uses' => 'NewsletterController@subscribed',
    ]);

    $router->get('newsletter/unsubscribe', [
       'uses' => 'NewsletterController@unsubscribe',
    ]);

    $router->post('newsletter/unsubscribe', [
       'uses' => 'NewsletterController@destroy',
    ]);

    $router->get('newsletter/unsubscribed', [
       'uses' => 'NewsletterController@unsubscribed',
    ]);
});
