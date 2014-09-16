<?php
namespace Product\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('product');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'itemname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Item Name',
            ),
        ));
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
        $this->add(array(
            'name' => 'boughtat',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Bought At',
            ),
        ));
        $this->add(array(
            'name' => 'overheads',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Overheads',
            ),
        ));
        $this->add(array(
            'name' => 'soldat',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Sold At',
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Checkbox',
            'name' => 'sold',
            'options' => array(
                'label' => 'Sold',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0'
            )
        ));
        $this->add(array(
            'name' => 'profit',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Profit'
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }
}