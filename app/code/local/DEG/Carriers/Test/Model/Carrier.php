<?php

class DEG_Carriers_Test_Model_Carrier extends EcomDev_PHPUnit_Test_Case_Config
{
    const TEST_CARRIER_CODE = 'test_carrier_code';

    /**
     * Tests save and load from core config
     */
    public function testSave()
    {
        /* @var $fromDb DEG_Carriers_Model_Carrier */
        /* @var $original DEG_Carriers_Model_Carrier */

        $code = self::TEST_CARRIER_CODE;
        $title = 'Test Carrier Title';
        $website = 'http://test.carrier.website.com/';
        $model = 'shipping/carrier_pickup';

        $original = Mage::getModel('DEG_Carriers/Carrier');
        $original->setId($code)
            ->setTitle($title)
            ->setWebsite($website)
            ->setModel($model)
            ->setUserDefined(true)
            ->save();

        $carrierHelper = self::_getHelper();
        $carrierHelper->cleanCarrierCache();

        $fromDb = Mage::getModel('DEG_Carriers/Carrier');
        $fromDb->load($code);

        $this->assertEquals($original->getId(), $fromDb->getId());
        $this->assertEquals($original->getTitle(), $fromDb->getTitle());
        $this->assertEquals($original->getWebsite(), $fromDb->getWebsite());
        $this->assertEquals($original->getModel(), $fromDb->getModel());
        $this->assertEquals($original->getUserDefined(), $fromDb->getUserDefined());
    }

    /**
     * Clean core config
     */
    public static function tearDownAfterClass()
    {
        $code = self::TEST_CARRIER_CODE;
        Mage::getConfig()->deleteConfig("carriers/$code");

        $carrierHelper = self::_getHelper();
        $carrierHelper->cleanCarrierCache();
    }

    /**
     * @return DEG_Carriers_Helper_Data
     */
    protected static function _getHelper()
    {
        return Mage::helper('DEG_Carriers');
    }
}
