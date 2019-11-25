<?php
/**
 * @category Ebizmarts
 * @package mailchimp-lib
 * @author Ebizmarts Team <info@ebizmarts.com>
 * @copyright Ebizmarts (http://ebizmarts.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cron processor class
 */
class Ebizmarts_MailChimp_Model_Cron
{
    /**
     * @var Ebizmarts_MailChimp_Helper_Data
     */
    protected $_mailChimpHelper;

    public function __construct()
    {
        $this->_mailChimpHelper = Mage::helper('mailchimp');
    }

    public function syncEcommerceBatchData()
    {
        Mage::log("B4 IF:  " . __METHOD__, null, "DUMP.log", true);

        if ($this->getHelper()->migrationFinished()) {
            Mage::log("Entró al if!! de: " . __METHOD__, null, "DUMP.log", true);
            Mage::getModel('mailchimp/api_batches')->handleEcommerceBatches();
            Mage::log("After OK!!!!!! if!! de: " . __METHOD__, null, "DUMP.log", true);
        } else {
            $this->getHelper()->handleMigrationUpdates();
        }
    }

    public function syncSubscriberBatchData()
    {
        Mage::getModel('mailchimp/api_batches')->handleSubscriberBatches();
    }

    public function processWebhookData()
    {
        Mage::getModel('mailchimp/processWebhook')->processWebhookData();
    }

    public function deleteWebhookRequests()
    {
        Mage::getModel('mailchimp/processWebhook')->deleteProcessed();
    }

    public function clearEcommerceData()
    {
        Mage::getModel('mailchimp/clearEcommerce')->clearEcommerceData();
    }

    protected function getHelper()
    {
        return $this->_mailChimpHelper;
    }
}
