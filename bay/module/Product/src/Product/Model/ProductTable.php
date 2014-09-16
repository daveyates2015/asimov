<?php
namespace Product\Model;

use Zend\Console\Prompt;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;

class ProductTable extends AbstractTableGateway
{

    protected $table = 'product';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Product());

        $this->initialize();
    }

    public function fetchAll(Select $select = null) {
        if (null === $select)
            $select = new Select();
        $select->from($this->table);
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getItem($id)
    {
        $id = (int)$id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getRecentItem()

    {

        $rowset = $this->select(function (Select $select) {
            $select->where->lessThan('date', date('Y-m-d H:i:s'));
            $select->order('date DESC')->limit(3);
        });
        if (!$rowset) {
            echo 'Nothing to show';
        }
        return $rowset;


    }


    public function saveProduct(Product $product)
    {
        $boughtAt = $product->boughtat;
        $overheads = $product->overheads;
        $soldAt = $product->soldat;


        $itemProfit = $soldAt - ($boughtAt + $overheads);




        $data = array(
            'itemname' => $product->itemname,
            'description' => $product->description,
            'boughtat' => $product->boughtat,
            'overheads' => $product->overheads,
            'soldat' => $product->soldat,

            'sold' => $product->sold,
            'profit' => $itemProfit,
        );

        $id = (int)$product->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getItem($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }


    public function deleteItem($id)
    {
        $this->delete(array('id' => $id));
    }
}