<?php class TheExtensionLab_StatusColors_Model_Resource_Setup extends Mage_Sales_Model_Resource_Setup
{
    public function addInstallationSuccessfulNotification(){
        $docUrl = "http://docs.theextensionlab.com/status-colors/installation.html";

        $inboxModel = Mage::getModel('adminnotification/inbox');

        if(!method_exists($inboxModel,'addNotice')){
            return;
        }

        $inboxModel->addNotice(
            'You have successfully installed TheExtensionLab_StatusColors:
            Status colors can be configured in System > Order Statuses and
            other config options found at System > Configuration > Advanced > Admin > Order Grid',
            'For full up to date documenation see <a href="'.$docUrl.'" target="_blank">'.$docUrl.'</a>',
            'http://docs.theextensionlab.com/status-colors/configuration.html',
            true
        );
    }
}