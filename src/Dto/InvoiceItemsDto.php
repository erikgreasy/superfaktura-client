<?php

namespace Erikgreasy\Superfaktura\Dto;

class InvoiceItemsDto
{
    /**
     * @param InvoiceItemDto[] $items
     */
    public function __construct(
        public readonly array $items = []
    )
    {
    }

    public function toArray(): array
    {
        return array_map(function (InvoiceItemDto $item) {
            return $item->toArray();
        }, $this->items);
    }
}
