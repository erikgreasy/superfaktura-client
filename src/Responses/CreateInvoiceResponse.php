<?php

namespace Erikgreasy\Superfaktura\Responses;

class CreateInvoiceResponse
{
    public function __construct(
        public readonly bool $error,
        public readonly string $errorMessage,
        public readonly string $invoiceId,
        public readonly string $invoiceToken,
    )
    {
    }
}
