<?php

use Biigle\SystemMessage;
use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Don't convert the important messages, as these will be converted to
        // the new "announcements".
        $importantType = DB::table('system_message_types')
            ->where('name', 'important')
            ->first();

        $insert = DB::table('system_messages')
            ->where('type_id', '!=', $importantType->id)
            ->select('created_at', 'updated_at', 'published_at', 'title as subject', 'body')
            ->get()
            ->map(function ($m) {
                // Strip HTML tags. This is important for readablilty and to remove any
                // email addresses from the publicly accessible newsletters.
                $m->body = preg_replace('/<[^>]*>/', '', $m->body);

                return (array) $m;
            })
            ->toArray();

        Newsletter::insert($insert);

        DB::table('system_messages')
            ->where('type_id', '!=', $importantType->id)
            ->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $infoType = DB::table('system_message_types')
            ->where('name', 'info')
            ->first();

        $insert = DB::table('newsletters')
            ->selectRaw("created_at, updated_at, published_at, subject as title, body, '{$infoType->id}'::int as type_id")
            ->get()
            ->map(fn($n) => (array) $n)
            ->toArray();

        SystemMessage::insert($insert);
        Newsletter::truncate();
    }
};
