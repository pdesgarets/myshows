<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'god',
            'PHP_AUTH_PW' => 'password'
        ));

        // Create a new entry in the database
        $crawler = $client->request('GET', '/user/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /user/");
        $crawler = $client->click($crawler->selectLink('Create a new user')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'user[email]'  => 'john@cagnol.com',
            'user[username]'  => 'johnc',
            'user[plainPassword][first]'  => 'password',
            'user[plainPassword][second]' => 'password'
        ));
        $form['user[roles]'][0]->tick();

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("johnc")')->count(), 'Missing element td:contains("johnc")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'user[username]'  => 'johnk'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "johnk"
        $this->assertGreaterThan(0, $crawler->filter('[value="johnk"]')->count(), 'Missing element [value="johnk"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/johnk/', $client->getResponse()->getContent());
    }

}
