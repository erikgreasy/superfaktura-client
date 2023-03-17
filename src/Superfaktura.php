<?php

namespace Erikgreasy\Superfaktura;

use Erikgreasy\Superfaktura\Enums\Language;

class Superfaktura
{
    private SuperfakturaClient $client;

    public function __construct(
        string $email,
        string $apiKey,
        bool $isSandbox = false,
        string $module = '',
    ) {
        $this->client = new SuperfakturaClient($email, $apiKey, $isSandbox, $module);
    }

    public function getInvoiceDetails(int $invoiceId): array
    {
        $data = $this->client->get("/invoices/view/{$invoiceId}.json");

        return $data;
    }

    public function createInvoice(array $invoiceData): array
    {
        $data = $this->client->post('/invoices/create', $invoiceData);

        if ($data['error'] !== 0) {
            if ($data['error'] === 4) {
                throw new \Exception('Missing require client data. Did you fill in the client name?');
            }

            if ($data['error'] === 5) {
                throw new \Exception('Posted data not correct. Did you pass any invoice items?');
            }

            throw new \Exception('Unknown exception with error code ' . $data['error']);
        }

        return $data;
    }

    public function getPdfUrl(string $invoiceId, string $invoiceToken): string
    {
        return $this->client->baseUrl() . "/invoices/pdf/{$invoiceId}/token:{$invoiceToken}";
    }

    /**
     * NOTE: The invoice is automatically marked as "sent via email" when
     * sending through their endopoint.
     */
    public function sendInvoiceViaMail(
        int $invoiceId,
        string $to,
        array $bcc = [],
        ?string $body = null,
        array $cc = [],
        ?Language $pdfLanguage = null,
        ?string $subject = null,
    ): array {
        $data = $this->client->post('/invoices/send', [
            'Email' => [
                'invoice_id' => $invoiceId,
                'to' => $to,
                'bcc' => $bcc,
                'body' => $body,
                'cc' => $cc,
                'pdf_language' => $pdfLanguage?->value,
                'subject' => $subject,
            ]
        ]);

        if ($data['error'] !== 0) {
            if ($data['error'] === 4) {
                throw new \Exception('Invoice not found.');
            }

            if ($data['error'] === 13) {
                throw new \Exception('Entered receipient email address is not valid.');
            }

            throw new \Exception('Could not sent email. ' . $data['error_message'] ?? '');
        }

        return $data;
    }

    public function markInvoiceAsSentByEmail(int $invoiceId, ?string $email = null, ?string $subject = null, ?string $message = null): array
    {
        $data = $this->client->post('/invoices/mark_as_sent', [
            'InvoiceEmail' => [
                'invoice_id' => $invoiceId,
                'email' => $email ?? '',
                'subject' => $subject ?? '',
                'message' => $message ?? '',
            ]
        ]);

        if ($data['error'] !== 0) {
            throw new \Exception($data['error_message'] ?? '');
        }

        return $data;
    }
}
