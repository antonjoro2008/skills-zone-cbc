<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Home page stat baselines
    |--------------------------------------------------------------------------
    |
    | Displayed totals are baseline + live count from the admin API
    | (GET /api/platform-stats). Keeps marketing numbers stable while
    | reflecting real growth from the platform database.
    |
    | active_users from the API is total registered accounts (all roles).
    | The home page label stays "Active Users".
    |
    */

    'baselines' => [
        'learners' => (int) env('PLATFORM_STATS_BASELINE_LEARNERS', 900),
        'active_users' => (int) env('PLATFORM_STATS_BASELINE_ACTIVE_USERS', 1200),
    ],

];
