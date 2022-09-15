<?php

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
