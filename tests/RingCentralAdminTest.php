<?php

namespace Coxy121\RingCentralLaravel\Tests;

use Coxy121\RingCentralLaravel\RingCentral;
use Dotenv\Dotenv;

class RingCentralAdminTest extends AbstractTestCase
{
	/** @var Coxy121\RingCentralLaravel\RingCentral */
    protected $ringCentral;

    public function setUp()
    {
        parent::setUp();

		$this->loadEnvironmentVariables();

		$this->ringCentral = new RingCentral();

		$this->ringCentral
            ->setClientId(env('RINGCENTRAL_CLIENT_ID'))
            ->setClientSecret(env('RINGCENTRAL_CLIENT_SECRET'))
            ->setServerUrl(env('RINGCENTRAL_SERVER_URL'))
            ->setUsername(env('RINGCENTRAL_USERNAME'))
            ->setOperatorExtension(env('RINGCENTRAL_OPERATOR_EXTENSION'))
            ->setOperatorPassword(env('RINGCENTRAL_OPERATOR_PASSWORD'));
    }

    protected function loadEnvironmentVariables()
    {
        if (! file_exists(__DIR__.'/../.env')) {
            return;
        }
        $dotenv = new Dotenv(__DIR__.'/..');
        $dotenv->load();
    }

    /** @test */
    public function it_can_retrieve_extensions()
    {
        $result = $this->ringCentral->getExtensions();

        $firstExtension = (array) $result[0];

        $this->assertArrayHasKey('id', $firstExtension);
        $this->assertArrayHasKey('extensionNumber', $firstExtension);
	}

	/** @test */
    public function it_can_retrieve_sent_sms_messages_for_a_given_extension_previous_24_hours()
    {
    	$this->ringCentral->authenticateAdmin();

        $result = $this->ringCentral->getMessagesForExtensionId($this->ringCentral->loggedInExtensionId());

        $firstMessage = (array) $result[0];

        $uriParts = explode('/', $firstMessage['uri']);
		$this->assertEquals($this->ringCentral->loggedInExtensionId(), $uriParts[8]);

		$this->assertArrayHasKey('id', $firstMessage);
        $this->assertArrayHasKey('to', $firstMessage);
        $this->assertArrayHasKey('from', $firstMessage);
        $this->assertArrayHasKey('subject', $firstMessage);
        $this->assertArrayHasKey('attachments', $firstMessage);
	}

    /** @test */
    public function it_can_retrieve_sent_sms_messages_for_a_given_extension_from_a_set_date()
    {
        $this->ringCentral->sendMessage([
            'to' => env('RINGCENTRAL_RECEIVER'),
            'text' => 'Test Message'
        ]);

        $result = $this->ringCentral->getMessagesForExtensionId(
            $this->ringCentral->loggedInExtensionId(), (new \DateTime())->modify('-1 mins')
        );

        $this->assertTrue(count($result) < 3);

        $firstMessage = (array) $result[0];

        $uriParts = explode('/', $firstMessage['uri']);
        $this->assertEquals($this->ringCentral->loggedInExtensionId(), $uriParts[8]);

        $this->assertArrayHasKey('id', $firstMessage);
        $this->assertArrayHasKey('to', $firstMessage);
        $this->assertArrayHasKey('from', $firstMessage);
        $this->assertArrayHasKey('subject', $firstMessage);
        $this->assertArrayHasKey('attachments', $firstMessage);
    }

    /** @test */
    public function it_can_retrieve_an_sms_messages_attachement()
    {
        $this->ringCentral->sendMessage([
            'to' => env('RINGCENTRAL_RECEIVER'),
            'text' => 'Test Message'
        ]);

        $result = $this->ringCentral->getMessagesForExtensionId(
            $this->ringCentral->loggedInExtensionId(), (new \DateTime())->modify('-1 mins')
        );

        $firstMessage = (array) $result[0];

        $attachment = $this->ringCentral->getMessageAttachmentById(
            $this->ringCentral->loggedInExtensionId(),
            $firstMessage['id'],
            $firstMessage['attachments'][0]->id
        );

        $this->assertNotNull($attachment->raw());
    }
}
