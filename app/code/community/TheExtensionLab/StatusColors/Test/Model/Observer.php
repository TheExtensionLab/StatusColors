<?php class TheExtensionLab_StatusColors_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @test
     * @return TheExtensionLab_StatusColors_Model_Observer
     */
    public function checkObserverClass()
    {
        $observer = Mage::getModel('theextensionlab_statuscolors/observer');
        $this->assertInstanceOf('TheExtensionLab_StatusColors_Model_Observer', $observer);
        return $observer;
    }
}