<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontControllerVideoTest extends WebTestCase
{
    public function testResults(): void
    {
        $client = static::createClient();
      
        $client->followRedirects();
        $crawler = $client->request ('GET', '/');
      
        $form = $crawler->selectButton('Search video')->form([
            'query' => 'aaa',
        ]);
      
        $crawler=$client->submit($form);

        $this->assertStringContainsString('No Results were found',$crawler->filter('h1')->text());

        $form = $crawler->selectButton('Search video')->form([
            'query' => 'Movies',
        ]);
       
        $crawler=$client->submit($form);
        $this->assertGreaterThan(2,$crawler->filter('h3')->count());
       
    }

}
