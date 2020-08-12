<?php
/**
 * @author hernan ariel de luca
 */
return [
    'exportConfig' => [
        'migrations' => base_path() . '/database/export/',
        'seeds' => base_path() . '/database/export/',
        'excel' => [
            'seed' => base_path() . '/database/export/',
            'migrations' => base_path() . '/database/export/'
        ],
        'seeder' => [
            'namespace' => '',
            'useClasses' => [
                'use Illuminate\Database\Seeder;'
            ]
        ],
        'mysql' => function ($action) {
            $action->registerSeeder('excel', new \Drc\DB\Exporter\Seeder\ExcelMySqlSeeder(config('database.connections.mysql.database')));
            return $action;
        }
    ]
];