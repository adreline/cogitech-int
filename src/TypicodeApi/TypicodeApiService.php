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
    public function fetchPosts(): ResponseInterface
    {
        return $this->client->request('GET', '/posts');
    }
    /**
     * @throws TransportExceptionInterface
     */
    public function fetchUsers(): ResponseInterface
    {
        return $this->client->request('GET', '/users');
    }




}
