<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Background Removal — Server-side processing
    |--------------------------------------------------------------------------
    |
    | The AI background removal runs on the server so the client never has to
    | download the model. Uploaded images and their results are stored under a
    | temporary directory and automatically deleted after `retention_minutes`.
    |
    */

    // Where temporary uploads/results live (relative to storage/app).
    'directory' => 'bg-removal',

    // How long (minutes) a processed image is kept before deletion.
    'retention_minutes' => (int) env('BG_REMOVAL_RETENTION_MINUTES', 30),

    // Max upload size accepted, in kilobytes (20 MB default).
    'max_file_kb' => (int) env('BG_REMOVAL_MAX_FILE_KB', 20480),

    // Allowed upload mime types.
    'allowed_mimetypes' => ['image/jpeg', 'image/png', 'image/webp'],

    // Max seconds the processor may run before being killed.
    'timeout' => (int) env('BG_REMOVAL_TIMEOUT', 120),

    /*
    | Driver used to run the AI:
    |   'http'    -> call a persistent Node micro-service over HTTP (recommended
    |               on cPanel "Setup Node.js App" / Passenger; model stays warm)
    |   'process' -> spawn a CLI command per request (needs exec/proc_open)
    */
    'driver' => env('BG_REMOVAL_DRIVER', 'http'),

    /*
    |--------------------------------------------------------------------------
    | HTTP driver — Node micro-service (scripts/remove-bg-server.cjs)
    |--------------------------------------------------------------------------
    */
    // Full URL of the worker's /remove endpoint, e.g.
    //   https://removebg.space/bgworker/remove   (cPanel Node app on a path)
    //   http://127.0.0.1:3000/remove             (standalone)
    'http_endpoint' => env('BG_REMOVAL_HTTP_ENDPOINT', 'http://127.0.0.1:3000/remove'),

    // Shared secret sent as the X-Worker-Secret header (must match the worker).
    'http_secret' => env('BG_REMOVAL_HTTP_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Process driver — CLI command
    |--------------------------------------------------------------------------
    | The command that performs the removal. Two placeholders are substituted
    | with shell-escaped absolute paths:
    |   {input}  -> uploaded source image
    |   {output} -> destination PNG (must be written by the processor)
    |
    | NOTE: on cPanel, use the ABSOLUTE node path from "Setup Node.js App", e.g.
    |   /home/USER/nodevenv/removebg.space/20/bin/node
    | You can also swap in Python rembg: "rembg i {input} {output}"
    */
    'processor' => env(
        'BG_REMOVAL_PROCESSOR',
        'node ' . base_path('scripts/remove-bg-worker.cjs') . ' {input} {output}'
    ),

    // Probability (1 in N requests) of running an opportunistic cleanup sweep,
    // so retention works even without the scheduler/cron configured.
    'sweep_lottery' => (int) env('BG_REMOVAL_SWEEP_LOTTERY', 20),
];
