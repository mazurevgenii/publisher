<?php

namespace Controller;

use App\Entity\Book;
use App\Entity\BookCategory;
use App\Tests\AbstractControllerTest;
use Doctrine\Common\Collections\ArrayCollection;

class BookControllerTest extends AbstractControllerTest
{
    public function testBooksByCategory(): void
    {
        $categoryId = $this->createCategory();

        $this->client->request('GET', '/api/v1/category/'.$categoryId.'/books');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'title', 'slug', 'image', 'authors', 'meap', 'publicationDate'],
                        'properties' => [
                            'title' => ['type' => 'string'],
                            'slug' => ['type' => 'string'],
                            'id' => ['type' => 'integer'],
                            'image' => ['type' => 'string'],
                            'meap' => ['type' => 'boolean'],
                            'publicationDate' => ['type' => 'integer'],
                            'authors' => [
                                'type' => 'array',
                                'items' => ['type' => 'string'],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function createCategory(): int
    {
        $bookCategory = (new BookCategory())->setTitle('Devices')->setSlug('devices');
        $this->em->persist($bookCategory);

        $book = (new Book())
            ->setTitle('Test book')
            ->setSlug('test-book')
            ->setImage('http://localhost.png')
            ->setMeap(false)
            ->setPublicationDate(new \DateTime())
            ->setAuthors(['Tester'])
            ->setCategories(new ArrayCollection([$bookCategory]));

        $this->em->persist($book);

        $this->em->flush();

        return $bookCategory->getId();
    }
}
