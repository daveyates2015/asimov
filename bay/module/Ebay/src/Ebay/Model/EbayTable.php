<?php
namespace Ebay\Model;

use Zend\Db\TableGateway\TableGateway;

class EbayTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getItem($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveItem(Ebay $bayList)
    {
        $data = array(
            'itemname' => $bayList->itemname,
            'price' => $bayList->price,
        );

        $id = (int)$bayList->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getAlbum($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteItem($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}