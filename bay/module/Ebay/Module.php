<?php
namespace Ebay;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Ebay\Model\Ebay;
use Ebay\Model\EbayTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{

    public function getAutoloaderConfig()
    {

        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {

        return array(

            'factories' => array(

                'Ebay\Model\EbayTable' => function ($sm) {
                        $tableGateway = $sm->get('EbayTableGateway');
                        $table = new EbayTable($tableGateway);
                        return $table;
                    },
                'EbayTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Ebay());
                        return new TableGateway('ebay', $dbAdapter, null, $resultSetPrototype);
                    },
            ),
        );


    }
}