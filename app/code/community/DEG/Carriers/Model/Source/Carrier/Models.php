<?php

class DEG_Carriers_Model_Source_Carrier_Models
{
    /**
     * @var null|array
     */
    protected $_options = null;

    /**
     * @var null|array
     */
    protected $_hash = null;

    /**
     * @return DEG_Carriers_Model_Resource_Carrier_Collection
     */
    protected function getCarriers()
    {
        $carriersCollection = Mage::getResourceModel('DEG_Carriers/Carrier_Collection');
        return $carriersCollection;
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        return $this->toOptionArray();
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        /* @var $carrier DEG_Carriers_Model_Carrier */

        if (!$this->_options) {
            $carriers = $this->getCarriers();
            $options = array();
            foreach ($carriers as $carrier) {
                $model = $carrier->getModel();
                $options[] = array('value' => $model, 'label' => $model);
            }

            $this->_options = $options;
        }

        return $this->_options;
    }

    /**
     * @return array
     */
    public function toOptionHash()
    {
        /* @var $carrier DEG_Carriers_Model_Carrier */

        if (!$this->_hash) {
            $carriers = $this->getCarriers();
            $hash = array();
            foreach ($carriers as $carrier) {
                $model = $carrier->getModel();
                $hash[$model] = $model;
            }

            $this->_hash = $hash;
        }

        return $this->_hash;
    }
}
