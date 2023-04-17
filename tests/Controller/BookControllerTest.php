<?php

namespace Controller;

use App\Controller\BookController;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testBooksByCategory(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/category/4/books');
        $responseContent = $client->getResponse()->getContent();

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonFile(
            __DIR__.'/responses/BookControllerTest_testBookCategory.json',
            $responseContent
        );
    }
}
