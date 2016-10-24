<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testResults()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'user_1',
            'PHP_AUTH_PW' => 'password'
        ));

        $crawler = $client->request('GET', '/search/results', array('q' => 'orange+is+the+new+black'));
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /search/results");
        $this->assertEquals(1, $crawler->filter('.show-card')->count(), 'Missing result');
    }

}
