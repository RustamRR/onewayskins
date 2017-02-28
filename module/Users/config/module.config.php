<?php
return array(
    'controllers' => array(
        'factories' => array(
            \Users\Controller\IndexController::class => \Users\Controller\IndexControllerFactory::class,
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            \Users\Service\UsersService::class => \Users\Service\UsersServiceFactory::class,
        ),
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => \Users\Entity\Users::class,
                'identity_property' => 'steamid',
                'credential_property' => 'password'
            ),
        ),
        'connection' => [
            'orm_default' => [
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
            ],
        ],
        'driver' => array(
            __NAMESPACE__ => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Entity')
            ),
            'orm_default' => [
                'drivers' => [
                    'Users\Entity' => __NAMESPACE__,
                ],
            ],

        ),
    ),
    'router' => array(
        'routes' => array(
            'users' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/cabinet',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        'controller'    => \Users\Controller\IndexController::class,
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(

                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        'controller' => \Users\Controller\IndexController::class,
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'excel_template'       => 'error/index',
        'template_map' => array_merge(
            include __DIR__ . '/../template_map.php'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
