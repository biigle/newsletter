<?php

use Biigle\Modules\Newsletter\Http\Requests\EmailVerificationRequest;

$router->get('newsletter', [
   'uses' => 'NewsletterController@index',
]);

$router->post('newsletter/subscribe', [
   'uses' => 'NewsletterController@create',
]);

$router->get('newsletter/verify', [
   'uses' => 'NewsletterController@created',
]);

Route::get('newsletter/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('newsletter/subscribed');
})->middleware(['signed'])->name('newsletter.verify');

$router->get('newsletter/subscribed', [
   'uses' => 'NewsletterController@subscribed',
]);
