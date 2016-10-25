<?php


namespace AppBundle\Tests\Controller;


use Liip\FunctionalTestBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{

    public function testHomepage()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertTrue($client->getResponse()->isRedirect());
        $this->assertRegExp('/\/login$/', $client->getResponse()->headers->get('location'));
    }
}