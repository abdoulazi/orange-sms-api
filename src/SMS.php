<?php

namespace Mediumart\Orange\SMS;

use Mediumart\Orange\SMS\Http\Requests\ContractsRequest;
use Mediumart\Orange\SMS\Http\Requests\OrdersHistoryRequest;
use Mediumart\Orange\SMS\Http\Requests\OutboundSMSRequest;
use Mediumart\Orange\SMS\Http\Requests\SMSDRCheckCallbackRequest;
use Mediumart\Orange\SMS\Http\Requests\SMSDRDeleteCallbackRequest;
use Mediumart\Orange\SMS\Http\Requests\SMSDRRegisterCallbackRequest;
use Mediumart\Orange\SMS\Http\Requests\StatisticsRequest;
use Mediumart\Orange\SMS\Http\SMSClient;

class SMS
{
    /**
     * @var string
     */
    protected $recipientNumber;
    /**
     * @var string
     */
    protected $senderNumber;

    /**
     * @var string
     */
    protected $senderName;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var SMSClient
     */
    protected $client;

    /**
     * Outbound SMS Object constructor.
     *
     * @param SMSClient $client
     */
    public function __construct(SMSClient $client)
    {
        $this->client = $client;
    }

     /**
      * Set SMS client.
      *
     * @param SMSClient $client
     * @return $this
     */
    public function setClient(SMSClient $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set SMS recipient.
     *
     * @param string $recipientNumber
     * @return $this
     */
    public function to($recipientNumber)
    {
        $this->recipientNumber = 'tel:'.$recipientNumber;

        return $this;
    }

    /**
     * set SMS sender details.
     *
     * @param string $number
     * @param null $name
     * @return $this
     */
    public function from($number, $name = null)
    {
        $this->senderNumber = 'tel:'.$number;

        $this->senderName = $name;

        return $this;
    }

    /**
     * Set SMS message.
     *
     * @param string $message
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Send SMS.
     *
     * @return array
     */
    public function send()
    {
        return $this->client->executeRequest(
            new OutboundSMSRequest(
                $this->message,
                $this->recipientNumber,
                $this->senderNumber,
                $this->senderName
            )
        );
    }

    /**
     * Get SMS contracts.
     *
     * @param null $country
     * @return array
     */
    public function balance($country = null)
    {
        return $this->client->executeRequest(
            new ContractsRequest($country)
        );
    }

    /**
     * Get SMS orders history.
     *
     * @param null $country
     * @return array
     */
    public function ordersHistory($country = null)
    {
        return $this->client->executeRequest(
            new OrdersHistoryRequest($country)
        );
    }

    /**
     * Get SMS statistics.
     *
     * @param null $country
     * @param null $appID
     * @return array
     */
    public function statistics($country = null, $appID = null)
    {
        return $this->client->executeRequest(
            new StatisticsRequest($country, $appID)
        );
    }

    /**
     * Set the SMS DR notification endpoint.
     *
     * @param $url
     * @return array
     */
    public function setDeliveryReceiptNotificationUrl($url)
    {
        return $this->client->executeRequest(
            new SMSDRRegisterCallbackRequest($url)
        );
    }

    /**
     * Check the SMS DR notification endpoint.
     *
     * @param $id
     * @return array
     */
    public function checkDeliveryReceiptNotificationUrl($id)
    {
        return $this->client->executeRequest(
            new SMSDRCheckCallbackRequest($id)
        );
    }

    /**
     * Delete the SMS DR notification endpoint.
     *
     * @param $id
     * @return array
     */
    public function deleteDeliveryReceiptNotificationUrl($id)
    {
        return $this->client->executeRequest(
            new SMSDRDeleteCallbackRequest($id)
        );
    }
}