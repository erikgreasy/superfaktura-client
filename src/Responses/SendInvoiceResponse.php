<?php

namespace Erikgreasy\Superfaktura\Responses;

class SendInvoiceResponse
{
    public function __construct(
        public readonly bool $error,
    )
    {
    }
}
