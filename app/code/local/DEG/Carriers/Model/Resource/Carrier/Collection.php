<?php

class DEG_Carriers_Model_Resource_Carrier_Collection extends Varien_Data_Collection
{
    /**
     * @var bool
     */
    protected $_isLoaded = false;

    /**
     * @param bool $printQuery
     * @param bool $logQuery
     * @throws Exception
     * @return Varien_Data_Collection
     */
    public function load($printQuery = false, $logQuery = false)
    {
        if (!$this->_isLoaded) {
            $config = Mage::getStoreConfig('carriers');
            foreach ($config as $code => $carrierConfig) {
                if (empty($carrierConfig['user_defined'])) {
                    continue;
                }

                $carrier = $this->_getModel();
                $carrier->load($code);
                $this->addItem($carrier);
            }

            $this->_isLoaded = true;
        }

        return $this;
    }

    /**
     * @return DEG_Carriers_Model_Carrier
     */
    protected function _getModel()
    {
        return Mage::getModel('DEG_Carriers/Carrier');
    }
}
