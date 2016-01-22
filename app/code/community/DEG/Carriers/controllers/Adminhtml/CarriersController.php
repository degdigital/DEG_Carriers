<?php

class DEG_Carriers_Adminhtml_CarriersController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('sales/carriers');
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * @throws Mage_Core_Exception
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $carrier = $this->_getCarrier()->load($id);
            if (!$carrier->getId()) {
                $adminHelper = $this->_getAdminHelper();
                Mage::getSingleton('adminhtml/session')->addError($adminHelper->__("Carrier with ID '$id' not found."));
                return $this->_redirect('*/*/index');
            }

            $carrier->delete();
            $carrierHelper = $this->_getCarrierHelper();
            $carrierHelper->cleanCarrierCache();
        }

        return $this->_redirect('*/*/index');
    }

    /**
     * @throws Mage_Core_Exception
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $carrier = $this->_getCarrier()->load($id);
            if (!$carrier->getId()) {
                $adminHelper = $this->_getAdminHelper();
                Mage::getSingleton('adminhtml/session')->addError($adminHelper->__("Carrier with ID '$id' not found."));
                return $this->_redirect('*/*/index');
            }

            Mage::register('current_carrier', $carrier);
        }

        $this->loadLayout();
        $this->_setActiveMenu('sales/carriers');
        $this->renderLayout();

        return $this;
    }

    public function saveAction()
    {
        $params = $this->getRequest()->getParams();
        $adminHelper = $this->_getAdminHelper();
        $carrierHelper = $this->_getCarrierHelper();

        try {
            $carrier = $this->_getCarrier()->load((int)$params['id']);
            $carrier->addData($params);
            $carrier->setData('user_defined', true);
            $carrier->save();

            $carrierHelper->cleanCarrierCache();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                $adminHelper->__('Shipping carrier saved successfully.')
            );
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addSuccess(
                $adminHelper->__('Something went wrong saving the shipping carrier: ' . $e->getMessage())
            );
        }

        $this->_redirect('*/*/index');
    }

    /**
     * @return DEG_Carriers_Helper_Data
     */
    protected function _getCarrierHelper()
    {
        return Mage::helper('DEG_Carriers');
    }

    /**
     * @return DEG_Carriers_Model_Carrier
     */
    protected function _getCarrier()
    {
        return Mage::getModel('DEG_Carriers/Carrier');
    }

    /**
     * @return Mage_Adminhtml_Helper_Data
     */
    protected function _getAdminHelper()
    {
        return Mage::helper('adminhtml');
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('admin/sales/carriers');
    }
}
