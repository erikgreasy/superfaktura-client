<?php

namespace Erikgreasy\Superfaktura\Enums;

enum InvoiceType: string
{
    case REGULAR = 'regular';
    case PROFORMA = 'proforma';
}
