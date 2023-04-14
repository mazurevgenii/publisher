<?php

namespace App\Model;

class BookCategoryListResponse
{
    public function __construct(private readonly array $items)
    {
    }

    /**
     * @return BookCategoryListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
