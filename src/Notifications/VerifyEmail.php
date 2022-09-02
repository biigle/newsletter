<?php

namespace Biigle\Modules\Newsletter\Notifications;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail as Base;
use Illuminate\Notifications\Messages\MailMessage;
use URL;

class VerifyEmail extends Base
{
    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Please click the button below to verify your email address for the BIIGLE newsletter.')
            ->action('Verify Email Address', $url)
            ->line('If you did not sign up for the newsletter, no further action is required.');
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'newsletter.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
