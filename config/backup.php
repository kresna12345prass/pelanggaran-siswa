<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Backup Configuration
    |--------------------------------------------------------------------------
    */

    'mysqldump_paths' => [
        'windows' => [
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            'C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe',
            'C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe',
        ],
        'linux' => [
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
        ],
        'fallback' => 'mysqldump'
    ],

    'storage_path' => 'backups',
    
    'max_backup_files' => 10, // Maksimal file backup yang disimpan
    
    'backup_options' => [
        '--single-transaction',
        '--routines',
        '--triggers',
        '--lock-tables=false'
    ]
];