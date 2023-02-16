<?php

namespace Erikgreasy\Superfaktura;

use Erikgreasy\Superfaktura\Dto\InvoiceDto;
use Erikgreasy\Superfaktura\Responses\CreateInvoiceResponse;
use Erikgreasy\Superfaktura\Responses\SendInvoiceResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class Superfaktura
{
    private string $sandboxUrl = 'https://sandbox.superfaktura.sk';
    private string $prodUrl = 'https://moja.superfaktura.sk';
    private string $module = '';
    private Client $client;

    public function __construct(
        private string $email, 
        private string $apiKey, 
        private bool $isSandbox = false
    )
    {
        $this->client = new Client([
            'headers' => [
                'Authorization' => "SFAPI email={$this->email}&apikey={$this->apiKey}&module={$this->module}"
            ]
        ]);
    }

    public function baseUrl(): string
    {
        if ($this->isSandbox) {
            return $this->sandboxUrl;
        }

        return $this->prodUrl;
    }

    public function post(string $url, array $data): ResponseInterface
    {
        try {
            return $this->client->post($this->baseUrl() . $url, [
                'form_params' => [
                    'data' => json_encode($data)
                ]
            ]);
        } catch(ClientException $e) {
            dd($e->getMessage());
        }
    }

    public function createInvoice(InvoiceDto $invoiceDto): CreateInvoiceResponse
    {
        $res = $this->post('/invoices/create', $invoiceDto->toArray());

        if ($res->getStatusCode() !== 200) {
            throw new \RuntimeException('Invoice was not created'); 
        }

        $resData = json_decode($res->getBody()->getContents());

        return new CreateInvoiceResponse(
            $resData->error,
            $resData->error_message,
            $resData->data->Invoice->id,
            $resData->data->Invoice->token,
        );
    }

    public function getPdfUrl(string $invoiceId, string $invoiceToken): string
    {
        return $this->baseUrl() . "/invoices/pdf/{$invoiceId}/token:{$invoiceToken}";
    }

    /**
     * The invoice is automatically marked as "sent via email" when
     * sending through their endopoint.
     */
    public function sendInvoice(array $data): SendInvoiceResponse
    {
        $res = $this->post('/invoices/send', $data);

        if ($res->getStatusCode() !== 200) {
            throw new \RuntimeException('Invoice was not sent'); 
        }

        $resData = json_decode($res->getBody()->getContents());

        return new SendInvoiceResponse(
            $resData->error
        );
    }

    public function markInvoiceAsSentByEmail(array $data): ResponseInterface
    {
        return $this->post('/invoices/mark_as_sent', $data);
    }
}
