<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        '1' => [
            'users' => 'c,r,u,d',
            'topics' => 'c,r,u,d',
            'user' => 'c,r,u,d',
            'posts' => 'c,r,u,d',
            'messages' => 'c,r,u,d',
            'portfolio' => 'c,r,u,d',
            'feedback' => 'c,r,u,d',
        ],
        '2' => [
            'users' => 'c,r,u,d',
            'topics' => 'c,r,u,d',
            'user' => 'c,r,u,d',
            'posts' => 'c,r,u,d',
            'messages' => 'c',
            'portfolio' => 'r',
            'feedback' => 'c,r,u,d',
        ],
        '3' => [
            'topics' => 'c,r',
            'posts' => 'c,r',
            'messages' => 'c',
            'portfolio' => 'r',
            'feedback' => 'c,r',
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
