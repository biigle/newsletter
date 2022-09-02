<?php

namespace Biigle\Modules\Newsletter;

use Biigle\Modules\Newsletter\Database\Factories\NewsletterSubscriberFactory;
use Biigle\Modules\Newsletter\Notifications\VerifyEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Notification;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;

class NewsletterSubscriber extends Model implements MustVerifyEmailContract
{
    use HasFactory, Notifiable, MustVerifyEmailTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Scope a query to all subscribers that are verified.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return NewsletterSubscriberFactory::new();
    }
}
