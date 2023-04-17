<?php

namespace App\Model;

class BookListResponse
{
    public function __construct(private readonly array $items)
    {
    }

    /**
     * @return BookListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
