<?php

namespace Erikgreasy\Superfaktura\Dto;

use Erikgreasy\Superfaktura\Enums\InvoiceType;

class InvoiceDto
{
    public function __construct(
        public readonly ClientDto $client,
        public readonly InvoiceItemsDto $items,
        public readonly InvoiceType $type = InvoiceType::REGULAR,
        public readonly bool $alreadyPaid = false,
        public readonly ?string $name = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'Invoice'  => [
                'name' => $this->name,
                'already_paid' => $this->alreadyPaid,
                'type' => $this->type->value,
            ],
            'InvoiceItem' => $this->items->toArray(),
            'Client' => $this->client->toArray()
        ];
    }
}
