<?php class TheExtensionLab_StatusColors_Model_Resource_Setup extends Mage_Sales_Model_Resource_Setup
{
    public function addInstallationSuccessfulNotification(){
        $docUrl = "http://docs.theextensionlab.com/status-colors/installation.html";
        Mage::getModel('adminnotification/inbox')->addNotice(
            '<strong>You have successfully installed TheExtensionLab_StatusColors:</strong>
            Status colors can be configured in System > Order Statuses and
            other configuration options found at System > Configuration > Advanced > Admin > Order Grid</a>',
            'For full up to date documenation see <a href="'.$docUrl.'" target="_blank">'.$docUrl.'</a>',
            'http://docs.theextensionlab.com/status-colors/configuration.html',
            true
        );
    }
}