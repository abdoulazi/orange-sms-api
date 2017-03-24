<?php

namespace Tests;

use Mediumart\Orange\SMS\Http\SMSClient;
use Mediumart\Orange\SMS\SMS;

class SMSTest extends TestCase
{
    /**
     * @var \Mediumart\Orange\SMS\SMS
     */
    private $SMS;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->SMS = new SMS(SMSClient::getInstance($this->token));
    }

    /**
     * @test
     */
    public function client_contracts_request()
    {
        $this->setupRequestContext('contracts');

        $this->assertSame(['partnerContracts' => []], $this->SMS->balance());
    }

    /**
     * @test
     */
    public function client_orders_history_request()
    {
        $this->setupRequestContext('ordersHistory');

        $this->assertSame(['purchaseOrders' => []], $this->SMS->ordersHistory());
    }

    /**
     * @test
     */
    public function client_statistics_request()
    {
        $this->setupRequestContext('statistics');

        $this->assertSame(['partnerStatistics' => []], $this->SMS->statistics());
    }

    /**
     * @test
     */
    public function client_outbound_sms_request()
    {
        $this->setupRequestContext('outboundSms');

        $response = $this->SMS->message('hello')
                              ->from('+123456789')
                              ->to('+987654321')
                              ->send();

        $this->assertSame(['outboundSMSMessageRequest' => []], $response);
    }
}