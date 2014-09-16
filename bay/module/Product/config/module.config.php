<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Product\Controller\Product' => 'Product\Controller\ProductController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'product' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/product[/:action][/:id][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),


                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action' => 'index',
                    ),
                ),
            ),
            'list' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/product/list[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action' => 'list',
                    ),
                ),
            ),

        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'product' => __DIR__ . '/../view',

        ),
        'template_map' => array(
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
    ),
);