<?php

namespace Biigle\Modules\Newsletter\Notifications;

use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Middleware\RateLimited;

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
     * Get the middleware the queued notification job should pass through.
     *
     * Limits the emails per hour (see the "newsletter.email_rate_limit" config). Jobs
     * that exceed the limit are released back to the queue and run later.
     *
     * @param  mixed  $notifiable
     * @param  string  $channel
     * @return array
     */
    public function middleware($notifiable, $channel)
    {
        return [new RateLimited('newsletter-emails')];
    }

    /**
     * Determine the time at which the queued notification should stop being retried.
     *
     * Each time a job is released because of the rate limit, this counts as an
     * attempt. Thus the retries are limited by time and not by the number of attempts.
     * The time must be long enough to send the newsletter to all subscribers with the
     * configured limit (e.g. 10000 subscribers at 400 per hour take 25 hours).
     *
     * @return \DateTimeInterface
     */
    public function retryUntil()
    {
        return now()->addDays(7);
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
