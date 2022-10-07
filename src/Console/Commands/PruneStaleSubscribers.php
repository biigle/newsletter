<?php

namespace Biigle\Modules\Newsletter\Console\Commands;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Illuminate\Console\Command;

class PruneStaleSubscribers extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newsletter:prune-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete newsletter subscribers who have not confirmed their subscription after two weeks';

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $pruneDate = now()->subWeeks(2);

        NewsletterSubscriber::whereNull('email_verified_at')
            ->where('created_at', '<', $pruneDate)
            ->eachById(function ($subscriber) {
                $subscriber->delete();
            });
    }
}
