<?php

class DEG_Carriers_Model_Shipping_Carrier_Tracking
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    /**
     * Rate result data
     *
     * @var Mage_Shipping_Model_Rate_Result|null
     */
    protected $_result = null;

    public function setId($code)
    {
        $this->_code = $code;
        return parent::setId($code);
    }

    /**
     * Collect rates for this shipping method based on information from request
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        return false;
    }

    /**
     * Returns allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return false;
    }

    /**
     * Check if carrier has shipping tracking option available
     *
     * @return boolean
     */
    public function isTrackingAvailable()
    {
        return true;
    }

    /**
     *
     * See Mage_Usa_Model_Shipping_Carrier_Abstract::getTrackingInfo
     *
     * @param $tracking
     * @return bool|mixed
     */
    public function getTrackingInfo($tracking)
    {
        if (!$this->getConfigData('website')) {
            return false;
        }

        $result = $this->getTracking($tracking);

        if ($result instanceof Mage_Shipping_Model_Tracking_Result) {
            if ($trackings = $result->getAllTrackings()) {
                return $trackings[0];
            }
        } elseif (is_string($result) && !empty($result)) {
            return $result;
        }

        return false;
    }

    /**
     * Get tracking
     *
     * @param mixed $trackings
     * @return mixed
     */
    public function getTracking($trackings)
    {
        /* @var $status Mage_Shipping_Model_Tracking_Result_Status */

        if (!is_array($trackings)) {
            $trackings = array($trackings);
        }

        $result = Mage::getModel('shipping/tracking_result');
        foreach ($trackings as $tracking) {
            $status = Mage::getModel('shipping/tracking_result_status');
            $status->setCarrier($this->_code);
            $status->setCarrierTitle($this->getConfigData('title'));
            $status->setTracking($tracking);
            $status->setPopup(1);
            $status->setUrl($this->getConfigData('website'));
            $result->append($status);
        }

        $this->_result = $result;
        return $this->_result;
    }
}
