<?php

$router->group([
    'namespace' => 'Api',
    'prefix' => 'api/v1',
    'middleware' => ['api', 'auth:web,api'],
], function ($router) {
    $router->resource('newsletters', 'NewsletterController', [
        'only' => ['store', 'update'],
        'parameters' => ['newsletters' => 'id'],
    ]);

    $router->resource('newsletter-subscribers', 'NewsletterSubscriberController', [
        'only' => ['destroy'],
        'parameters' => ['newsletter-subscribers' => 'id'],
    ]);
});

$router->group([
    'namespace' => 'Views',
], function ($router) {
    $router->get('admin/newsletter', [
       'uses' => 'AdminController@index',
       'middleware' => ['auth:web', 'can:sudo'],
       'as' => 'newsletter.admin.index',
    ]);

    $router->get('newsletter', [
       'uses' => 'NewsletterController@index',
    ]);

    $router->post('newsletter/subscribe', [
       'uses' => 'NewsletterController@create',
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
