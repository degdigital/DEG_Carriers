<?php

class DEG_Carriers_Block_Adminhtml_Carriers_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return DEG_Carriers_Model_Carrier
     */
    protected function getModel()
    {
        if (!Mage::registry('current_carrier')) {
            Mage::register('current_carrier', Mage::getModel('DEG_Carriers/Carrier'));
        }

        return Mage::registry('current_carrier');
    }

    protected function _prepareForm()
    {
        $carrierSource = $this->_getCarrierSource();

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset('edit_carrier', array($this->__('Edit Carrier')));

        $fieldset->addField('id', 'text', array(
            'name' => 'id',
            'label' => 'Carrier Code',
            'class' => 'required-entry validate-xml-identifier',
            'required' => true,
            'disabled' => (bool)$this->getModel()->getId(),
            'value' => $this->getModel()->getId(),
        ));

        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => $this->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'value' => $this->getModel()->getTitle()
        ));

        $fieldset->addField('website', 'text', array(
            'name' => 'website',
            'label' => $this->__('Website URL'),
            'value' => $this->getModel()->getWebsite()
        ));

        $fieldset->addField('model', 'select', array(
            'name' => 'model',
            'label' => $this->__('Carrier Model'),
            'class' => 'required-entry',
            'required' => true,
            'value' => $this->getModel()->getModel(),
            'options' => $carrierSource->toOptionHash()
        ));

        return parent::_prepareForm();
    }

    /**
     * @return DEG_Carriers_Model_Source_Carrier_Models
     */
    protected function _getCarrierSource()
    {
        return Mage::getSingleton('DEG_Carriers/Source_Carrier_Models');
    }
}
