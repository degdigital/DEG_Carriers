<?php

/**
 * Model that wraps logic for loading and saving carrier data into core config.
 *
 * @method string getTitle()
 * @method string getWebsite()
 * @method string getModel()
 * @method bool   getUserDefined()
 * @method DEG_Carriers_Model_Carrier setTitle(string $title)
 * @method DEG_Carriers_Model_Carrier setWebsite(string $website)
 * @method DEG_Carriers_Model_Carrier setModel(string $model)
 * @method DEG_Carriers_Model_Carrier setUserDefined(bool $userDefined)
 */
class DEG_Carriers_Model_Carrier extends Varien_Object
{
    /**
     * @var null|Mage_Shipping_Model_Carrier_Abstract
     */
    protected $_carrierInstance = null;

    /**
     * @param int $id carrier code
     * @return $this
     */
    public function load($id)
    {
        $this->_carrierInstance = Mage::getSingleton('shipping/config')->getCarrierInstance($id);
        $config = Mage::getStoreConfig("carriers/$id");
        if (is_array($config)) {
            $this->addData(array_filter($config));
            $this->setId($id);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function save()
    {
        $carrierCode = $this->getId();
        foreach ($this->getData() as $key => $value) {
            Mage::getConfig()
                ->saveConfig("carriers/$carrierCode/$key", $value); //Magento saves carrier data in core config
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function delete()
    {
        $carrierCode = $this->getId();
        foreach ($this->getData() as $key => $value) {
            Mage::getConfig()->deleteConfig("carriers/$carrierCode/$key");
        }

        return $this;
    }

    /**
     * Set object id field value
     *
     * @param   mixed $value
     * @return  DEG_Carriers_Model_Carrier
     */
    public function setId($value)
    {
        return parent::setId($value);
    }
}