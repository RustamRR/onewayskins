<?php
return array(
    'controllers' => array(
        'factories' => array(
            \Users\Controller\IndexController::class => \Users\Controller\IndexControllerFactory::class,
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
            'coursefile' => [
                'type'    => 'Literal',
                'options' => [
                    'route'    => '/my',
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'downloadEntity' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/my',
                            'constraints' => [
                                'alias' => '[a-zA-Z-]+',
                                'id' => '[0-9]+',
                            ],
                            'defaults' => [
                                'controller' => \Users\Controller\IndexController::class,
                                'action' => 'my',
                            ],
                        ],
                    ],
                ]
            ],
        ),
    ),
    'view_manager'    => array(
        'template_map' => include __DIR__ . '/../template_map.php',
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
