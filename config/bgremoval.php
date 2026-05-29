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
    | The command that performs the removal. Two placeholders are substituted
    | with shell-escaped absolute paths:
    |   {input}  -> uploaded source image
    |   {output} -> destination PNG (must be written by the processor)
    |
    | Default: a bundled Node worker using @imgly/background-removal-node
    | (same model as the previous in-browser version, now cached server-side).
    | You can swap this for any CLI, e.g. Python rembg:
    |   BG_REMOVAL_PROCESSOR="rembg i {input} {output}"
    */
    'processor' => env(
        'BG_REMOVAL_PROCESSOR',
        'node ' . base_path('scripts/remove-bg-worker.cjs') . ' {input} {output}'
    ),

    // Probability (1 in N requests) of running an opportunistic cleanup sweep,
    // so retention works even without the scheduler/cron configured.
    'sweep_lottery' => (int) env('BG_REMOVAL_SWEEP_LOTTERY', 20),
];
