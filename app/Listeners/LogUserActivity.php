<?php

namespace App\Listeners;

use App\Events\UserActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserActivity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserActivity  $event
     * @return void
     */
    public function handle(UserActivity $event)
    {
        // Logic to log user activity, update last activity timestamp, or any other actions you want to perform.
        // For example, store the activity log in the database.
        $activityLog = [
            'user_id' => $event->user->id,
            'activity' => 'User accessed a page', // Update this based on actual user activity
            'created_at' => now(),
        ];

        // Save the activity log to the database.
        // Your implementation may vary depending on the database and Eloquent models you use.
        ActivityLog::create($activityLog);
    }
}









