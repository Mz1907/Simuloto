<?php

namespace SimulotoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LottoControllerTest extends WebTestCase
{
    public function testResult()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/result');
    }

    public function testBuildscore()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/buildScore');
    }
    
    
}
