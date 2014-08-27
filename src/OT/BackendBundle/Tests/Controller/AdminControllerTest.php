<?php

namespace OT\BackendBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testDashboard()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/dashboard');
    }

    public function testTeacher()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/teacher');
    }

    public function testLearner()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/learner');
    }

    public function testCouse()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/couse');
    }

    public function testAccount()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/account');
    }

    public function testSetting()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/setting');
    }

}
