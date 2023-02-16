<?php

namespace Erikgreasy\Superfaktura\Dto;

class ClientDto
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $address = null,
        public readonly ?string $zip = null,
        public readonly ?string $city = null,
        public readonly ?string $country = null,
        public readonly ?string $ico = null,
        public readonly ?string $dic = null,
        public readonly ?string $icdph = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
            'ico' => $this->ico,
            'dic' => $this->dic,
            'icdph' => $this->icdph,
        ];
    }
}
