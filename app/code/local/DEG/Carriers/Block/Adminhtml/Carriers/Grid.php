<?php

class DEG_Carriers_Block_Adminhtml_Carriers_Grid extends DigitalEvolution_Adminhtml_Block_Widget_Grid
{
    protected function _construct()
    {
        $this->setPagerVisibility(false);
        $this->setUseAjax(true);
        $this->setId('adminhtml_prescription_form');
        parent::_construct();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $carriersCollection = Mage::getResourceModel('DEG_Carriers/Carrier_Collection');
        $this->setCollection($carriersCollection);

        return parent::_prepareCollection();
    }

    /**
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $helper = $this->_getHelper();
        $carrierSource = $this->_getCarrierSource();

        $this->addColumn('id', array(
            'header' => $helper->__('Name'),
            'index' => 'id',
            'filter_condition_callback' => array($this, '_filterFieldCondition')
        ));

        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index' => 'title',
            'filter_condition_callback' => array($this, '_filterFieldCondition')
        ));

        $this->addColumn('website', array(
            'header' => $helper->__('Website'),
            'index' => 'website',
            'filter_condition_callback' => array($this, '_filterFieldCondition')
        ));

        $this->addColumn('model', array(
            'header' => $helper->__('Model'),
            'index' => 'model',
            'type' => 'options',
            'options' => $carrierSource->toOptionHash(),
            'filter_condition_callback' => array($this, '_filterFieldCondition')
        ));

        parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * @param DEG_Carriers_Model_Carrier $item
     * @return string
     */
    public function getRowUrl($item)
    {
        return $this->getUrl('*/*/edit', array('id' => $item->getId()));
    }

    /**
     * @return DEG_Carriers_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('DEG_Carriers');
    }

    /**
     * @param DEG_Carriers_Model_Resource_Carrier_Collection $collection
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
     */
    protected function _filterFieldCondition($collection, $column)
    {
        /* @var $carrier DEG_Carriers_Model_Carrier */

        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $field = ($column->getFilterIndex()) ? $column->getFilterIndex() : $column->getIndex();

        foreach ($collection as $key => $carrier) {
            if (strpos($carrier->getData($field), $value) === false) {
                $collection->removeItemByKey($key);
            }
        }
    }

    /**
     * @return DEG_Carriers_Model_Source_Carrier_Models
     */
    protected function _getCarrierSource()
    {
        return Mage::getSingleton('DEG_Carriers/Source_Carrier_Models');
    }
}
