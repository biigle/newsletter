<?php

namespace Biigle\Modules\Newsletter;

use Biigle\Modules\Newsletter\Database\Factories\NewsletterFactory;
use Biigle\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Notification;

class Newsletter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'body'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Scope a query to all draft newsletters
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDraft($query)
    {
        return $query->whereNull('published_at');
    }

    /**
     * Publishes this newsletter if it wasn't alerady published.
     */
    // public function publish()
    // {
    //     if (!is_null($this->published_at)) {
    //         return;
    //     }

    //     $this->published_at = Carbon::now();
    //     $this->save();
    //     $users = User::select('id')->get();
    //     Notification::send($users, new NewSystemMessageNotification($this));
    // }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return NewsletterFactory::new();
    }
}
