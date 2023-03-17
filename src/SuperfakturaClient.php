<?php

namespace Erikgreasy\Superfaktura;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;

class SuperfakturaClient
{
    private string $sandboxUrl = 'https://sandbox.superfaktura.sk';
    private string $prodUrl = 'https://moja.superfaktura.sk';
    private Client $client;

    public function __construct(
        private string $email,
        private string $apiKey,
        private bool $isSandbox = false,
        private string $module = ''
    ) {
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


    public function get(string $url): array
    {
        try {
            $res = $this->client->get($this->baseUrl() . $url);

            return json_decode($res->getBody()->getContents(), true);
        } catch (ClientException $e) {
            throw $e;
        }
    }

    public function post(string $url, array $data): array
    {
        try {
            $res = $this->client->post($this->baseUrl() . $url, [
                'form_params' => [
                    'data' => json_encode($data)
                ]
            ]);

            return json_decode($res->getBody()->getContents(), true);
        } catch (ClientException $e) {
            throw $e;
        }
    }
}
