<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class TVShowControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtureFiles(array('@AppBundle/DataFixtures/ORM/users.yml'));
    }

    public function testDisplay()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user_1',
            'PHP_AUTH_PW' => 'password'
        ));

        $crawler = $client->request('GET', '/tv_show/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /search/results");
        $this->assertEquals(1, $crawler->filter('.summary')->count(), 'Missing show summary');
        $this->assertEquals(1, $crawler->filter('.img-thumbnail')->count(), 'Missing show thumbnail');

    }

}
