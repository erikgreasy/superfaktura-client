<?php

namespace Erikgreasy\Superfaktura;

class Invoice
{
    private array $invoice = [];
    private array $items = [];
    private array $client = [];
    private array $myData = [];
    private array $invoiceSetting = [];
    private array $invoiceExtra = [];

    public function __construct(protected Superfaktura $superfaktura)
    {
    }

    public function setInvoice(array $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
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
    
    public function setMyData(array $myData): self
    {
        $this->myData = $myData;

        return $this;
    }

    public function setInvoiceExtra(array $invoiceExtra): self
    {
        $this->invoiceExtra = $invoiceExtra;

        return $this;
    }

    public function setInvoiceSetting(array $invoiceSetting): self
    {
        $this->invoiceSetting = $invoiceSetting;

        return $this;
    }

    public function save(): array
    {
        return $this->superfaktura->createInvoice([
            'Invoice' => $this->invoice,
            'InvoiceItem' => $this->items,
            'Client' => $this->client,
            'MyData' => $this->myData,
            'InvoiceSetting' => $this->invoiceSetting,
            'InvoiceExtra' => $this->invoiceExtra,
        ]);
    }
}
