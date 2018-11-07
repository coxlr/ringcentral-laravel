<?php

namespace Coxy121\RingCentralLaravel\Tests;

use Coxy121\RingCentralLaravel\RingCentral;

class TestServiceProvider extends AbstractTestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('ringcentral.client_id', 'my_client_id');
        $app['config']->set('ringcentral.client_secret', 'my_client_secret');
        $app['config']->set('ringcentral.server_url', 'my_server_url');
        $app['config']->set('ringcentral.username', 'my_username');
        $app['config']->set('ringcentral.operator_extension', 'my_operator_extension');
        $app['config']->set('ringcentral.operator_password', 'my_operator_password');
        $app['config']->set('ringcentral.admin_extension', 'my_admin_extension');
        $app['config']->set('ringcentral.admin_password', 'my_admin_password');
    }

    /** @test */
    public function it_resolves_from_the_service_container()
    {
        $ringCentral = app('ringcentral');

        $this->assertInstanceOf(RingCentral::class, $ringCentral);

        $this->assertEquals('my_client_id', $ringCentral->clientId());
        $this->assertEquals('my_client_secret', $ringCentral->clientSecret());
        $this->assertEquals('my_server_url', $ringCentral->serverUrl());
        $this->assertEquals('my_username', $ringCentral->username());
        $this->assertEquals('my_operator_extension', $ringCentral->operatorExtension());
        $this->assertEquals('my_operator_password', $ringCentral->operatorPassword());
        $this->assertEquals('my_admin_extension', $ringCentral->adminExtension());
        $this->assertEquals('my_admin_password', $ringCentral->adminPassword());

    }
}
