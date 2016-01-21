<?php

class DEG_Carriers_Block_Adminhtml_Carriers_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'DEG_Carriers_Adminhtml';
        $this->_controller = 'Carriers';
        $this->_objectId = 'id';

        parent::__construct();
    }

    public function getHeaderText()
    {
        $carrier = Mage::registry('current_carrier');
        if ($carrier && $carrier->getId()) {
            return $this->__('Edit %s', $carrier->getTitle());
        } else {
            return $this->__('New Carrier');
        }
    }
}
