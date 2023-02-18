<?php

namespace Erikgreasy\Superfaktura\Dto;

class InvoiceItemDto
{
    public function __construct(
        public readonly string $name,
        public readonly float $unitPrice,
        public readonly ?string $description = null,
        public readonly float $quantity = 1,
        public readonly ?string $unit = null,
        public readonly ?float $tax = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'unit_price' => $this->unitPrice,
            'unit' => $this->unit,
            'tax' => $this->tax,
        ];
    }
}
