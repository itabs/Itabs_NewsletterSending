<?php
/**
 * This file is part of the Itabs_NewsletterSending module.
 *
 * PHP version 5
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category  Itabs
 * @package   Itabs_NewsletterSending
 * @author    Rouven Alexander Rieker <rouven.rieker@itabs.de>
 * @copyright 2012 ITABS GmbH / Rouven Alexander Rieker (http://www.itabs.de)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://github.com/itabs/Itabs_NewsletterSending
 */
/**
 * Overloaded Observer class from Magento core module to add system configuration values
 *
 * @category  Itabs
 * @package   Itabs_NewsletterSending
 * @author    Rouven Alexander Rieker <rouven.rieker@itabs.de>
 * @copyright 2012 ITABS GmbH / Rouven Alexander Rieker (http://www.itabs.de)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://github.com/itabs/Itabs_NewsletterSending
 */
class Itabs_NewsletterSending_Model_Observer extends Mage_Newsletter_Model_Observer
{
    const XML_PATH_NEWSLETTER_SENDING_COUNT_QUEUE = 'newsletter/sending/count_of_queue';
    const XML_PATH_NEWSLETTER_SENDING_COUNT_SUBSCRIBER = 'newsletter/sending/count_of_subscriptions';

    /**
     * Schedules the sending process of the newsletters
     *
     * @param unknown_type $schedule
     * @return void
     */
    public function scheduledSend($schedule)
    {
        $countOfQueue = Mage::getStoreConfig(self::XML_PATH_NEWSLETTER_SENDING_COUNT_QUEUE);
        $countOfSubscriptions = Mage::getStoreConfig(self::XML_PATH_NEWSLETTER_SENDING_COUNT_SUBSCRIBER);

        $collection = Mage::getModel('newsletter/queue')->getCollection()
            ->setPageSize($countOfQueue)
            ->setCurPage(1)
            ->addOnlyForSendingFilter()
            ->load();

         $collection->walk('sendPerSubscriber', array($countOfSubscriptions));
    }
}