<?php

namespace GraphQLTestClient;

use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Foundation\Application;

class LaravelTestClient extends Client
{
    use MakesHttpRequests;

    /** @var Application */
    private $app;

    /** @var Response */
    protected $response;

    /**
     * WebTestGraphQLClient constructor.
     *
     * @param Application $app
     * @param string      $baseUrl
     */
    public function __construct(Application $app, string $baseUrl)
    {
        parent::__construct($baseUrl);
        $this->app = $app;
    }

    protected function postQuery(array $data): array
    {
        $this->response = $this->post($this->getBaseUrl(), $data);
        return json_decode($this->response->getContent(), true);
    }
}
