<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class TVShowControllerTest extends WebTestCase
{
    public function setUp()
    {
        try {
            $this->loadFixtureFiles(array('@AppBundle/DataFixtures/ORM/users.yml'));
        } catch (\Exception $e) {
        }
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

    public function testAddThenRemoveFromFavoriteTest() {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user_1',
            'PHP_AUTH_PW' => 'password'
        ));
        $url_redirect = '/tv_show/1';
        $expected_cases = array('success', 'warning');
        $scenari = array(
            'Add'    => array('url' => '/tv_show/addToFav/1'),
            'Remove' => array('url' => '/tv_show/removeFromFav/1')
        );

        foreach ($scenari as $scenario => $item) {
            for ($i=0; $i<2; $i++) {
                $crawler = $client->request('GET', $item['url']);
                $this->assertTrue($client->getResponse()->isRedirect($url_redirect), 'Case "'.$scenario.'" : Failed to redirect to "'.$url_redirect.'"');
                $session = $client->getContainer()->get('session');
                $this->assertArrayHasKey($expected_cases[$i], $session->getBag('flashes')->all());
            }
        }

    }

}
