<?php

namespace CmsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/page');
    }

}
