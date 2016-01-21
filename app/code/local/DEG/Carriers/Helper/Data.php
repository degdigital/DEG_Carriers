<?php

class DEG_Carriers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function cleanCarrierCache()
    {
        Mage::app()->getCacheInstance()->cleanType('config'); //Magento saves carrier data in core config
    }
}