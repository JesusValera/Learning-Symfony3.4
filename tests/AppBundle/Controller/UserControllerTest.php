<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUsers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users/');
        $link = $crawler->filter('a:contains("Login")')->link();

        $client->click($link);

        $this->assertRegExp('/\/login$/', $client->getRequest()->getUri());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}
