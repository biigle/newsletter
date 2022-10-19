<?php

namespace Biigle\Modules\Newsletter\Notifications;

use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNewsletter extends Notification implements ShouldQueue
{
    use Queueable;

    public Newsletter $newsletter;

    /**
     * Create a new instance.
     *
     * @param Newsletter $newsletter
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->newsletter->subject)
            ->replyTo(config('biigle.admin_email'))
            ->markdown('newsletter::mail.newsletter', [
                'body' => $this->newsletter->body,
                'subcopy' => 'hello'
            ]);
    }
}
