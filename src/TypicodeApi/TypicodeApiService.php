<?php

namespace App\TypicodeApi;

use RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TypicodeApiService
{

    private HttpClientInterface $client;
    private ParameterBagInterface $params;

    /**
     * @throws RuntimeException
     * @throws TransportExceptionInterface
     */
    public function __construct(
        HttpClientInterface $client,
        ParameterBagInterface $params,
    ) {
        $this->client = $client;
        $this->params = $params;
        $this->client = $client->withOptions([
            'base_uri' => $params->get('app.api.base_uri')
        ]);
    }
    /**
     * @throws TransportExceptionInterface
     */
    private function fetch(string $uri): array
    {
        $response = $this->client->request('GET', $uri);
        $data = $response->getContent();
        return json_decode($data, true);
    }
    /**
     * @throws TransportExceptionInterface
     */
    public function fetchPosts(): array
    {
        return $this->fetch('/posts');
    }
    /**
     * @throws TransportExceptionInterface
     */
    public function fetchUsers(): array
    {
        return $this->fetch('/users');
    }




}
