<?php
namespace Product\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Product\Model\Product;
use Product\Form\ProductForm;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator as paginatorIterator;


class ProductController extends AbstractActionController
{

    protected $productTable;

    public function indexAction()
    {


        return new ViewModel(array(
            'dates' => $this->getProductTable()->getRecentItem(),
        ));


    }

    public function listAction()
    {

        $select = new Select();

        $order_by = $this->params()->fromRoute('order_by') ?
            $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ?
            $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
        $page = $this->params()->fromRoute('page') ? (int)$this->params()->fromRoute('page') : 1;

        $products = $this->getProductTable()->fetchAll($select->order($order_by . ' ' . $order));
        $itemsPerPage = 10;

        $products->current();

        $paginator = new Paginator(new paginatorIterator($products));
        $paginator->setCurrentPageNumber($page)
            ->setItemCountPerPage($itemsPerPage)
            ->setPageRange(7);


        return new ViewModel(array(
            'products' => $this->getProductTable()->fetchAll($select),
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'paginator' => $paginator,
        ));


    }

    public function addAction()
    {
        $form = new ProductForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $product = new Product();
            $form->setInputFilter($product->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $product->exchangeArray($form->getData());
                $this->getProductTable()->saveProduct($product);

                return $this->redirect()->toRoute('list');
            }
        }
        return array('form' => $form);

    }

    public function editAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product', array(
                'action' => 'add'
            ));
        }
        $item = $this->getProductTable()->getItem($id);

        $form = new ProductForm();
        $form->bind($item);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($item->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getProductTable()->saveProduct($form->getData());

                return $this->redirect()->toRoute('list');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );

    }

    public function deleteAction()
    {

        $id = (int)$this->params()->fromRoute('id', 0);
        $this->getProductTable()->deleteItem($id);
        return $this->redirect()->toRoute('list');


    }

    public function getProductTable()
    {
        if (!$this->productTable) {
            $sm = $this->getServiceLocator();
            $this->productTable = $sm->get('Product\Model\ProductTable');
        }
        return $this->productTable;
    }


}