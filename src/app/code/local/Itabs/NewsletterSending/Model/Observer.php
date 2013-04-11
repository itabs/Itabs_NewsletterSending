<?php
/**
 * This file is part of the Itabs_NewsletterSending extension.
 *
 * PHP version 5
 *
 * @category  Itabs
 * @package   Itabs_NewsletterSending
 * @author    Rouven Alexander Rieker <rouven.rieker@itabs.de>
 * @copyright 2013 ITABS GmbH (http://www.itabs.de/). All rights served.
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   1.0.0
 * @link      https://github.com/itabs/Itabs_NewsletterSending
 */
/**
 * Overloaded Observer class from Magento core module to add system configuration values
 *
 * @category  Itabs
 * @package   Itabs_NewsletterSending
 * @author    Rouven Alexander Rieker <rouven.rieker@itabs.de>
 * @copyright 2013 ITABS GmbH (http://www.itabs.de/). All rights served.
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version   1.0.0
 * @link      https://github.com/itabs/Itabs_NewsletterSending
 */
class Itabs_NewsletterSending_Model_Observer extends Mage_Newsletter_Model_Observer
{
    /**
     * @var string
     */
    const XML_PATH_NEWSLETTER_SENDING_COUNT_QUEUE = 'newsletter/sending/count_of_queue';

    /**
     * @var string
     */
    const XML_PATH_NEWSLETTER_SENDING_COUNT_SUBSCRIBER = 'newsletter/sending/count_of_subscriptions';

    /**
     * Schedules the sending process of the newsletters
     *
     * @param unknown_type $schedule
     * @return void
     */
    public function scheduledSend($schedule)
    {
        $countOfQueue = (int) Mage::getStoreConfig(self::XML_PATH_NEWSLETTER_SENDING_COUNT_QUEUE);
        $countOfSubscriptions = (int) Mage::getStoreConfig(self::XML_PATH_NEWSLETTER_SENDING_COUNT_SUBSCRIBER);

        $collection = Mage::getModel('newsletter/queue')->getCollection()
            ->setPageSize($countOfQueue)
            ->setCurPage(1)
            ->addOnlyForSendingFilter()
            ->load();

         $collection->walk('sendPerSubscriber', array($countOfSubscriptions));
    }
}
