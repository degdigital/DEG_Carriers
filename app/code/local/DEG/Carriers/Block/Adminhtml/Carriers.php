<?php

class DEG_Carriers_Block_Adminhtml_Carriers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'DEG_Carriers_Adminhtml';
        $this->_controller = 'Carriers';
        $this->_headerText = $this->__('Shipping Carriers');

        parent::_construct();
    }
}
