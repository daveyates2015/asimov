<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Ebay\Controller\Ebay' => 'Ebay\Controller\EbayController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'ebay' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/ebay[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Ebay\Controller\Ebay',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ebay' => __DIR__ . '/../view',
        ),
    ),
);