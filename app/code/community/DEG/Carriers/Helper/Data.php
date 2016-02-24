<?php

class DEG_Carriers_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function cleanCarrierCache()
    {
        Mage::app()->getStore()->resetConfig(); //Magento saves carrier data in core config
    }
}