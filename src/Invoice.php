<?php

namespace Erikgreasy\Superfaktura;

class Invoice
{
    private array $invoice = [];
    private array $items = [];
    private array $client = [];

    public function __construct(protected Superfaktura $superfaktura)
    {
    }

    public function setClient(array $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function addItem(array $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function save(): array
    {
        return $this->superfaktura->createInvoice([
            'Invoice' => $this->invoice,
            'InvoiceItem' => $this->items,
            'Client' => $this->client,
        ]);
    }
}
