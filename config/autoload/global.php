<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'doctrine' => [
        'migrations_configuration' => [
            'orm_default' => [
                'namespace' => 'OrmDefaultMigrations',
                'directory' => __DIR__ . '/../../migrations/orm_default',
                'table' => 'doctrine_migration_versions',
            ],
        ],
        'connection' => [
            'orm_default' => [
                'params' => [
                    'host' => '',
                    'port' => '',
                    'user' => '',
                    'password' => '',
                    'dbname' => '',
                    'driver' => '',
                ]
            ],
        ]
    ],
    'service_manager' => [
        'factories' => [
            'doctrine.entitymanager.orm_default' => new DoctrineORMModule\Service\EntityManagerFactory('orm_default'),
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],

];
