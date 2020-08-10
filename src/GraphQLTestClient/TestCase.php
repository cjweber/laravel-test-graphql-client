<?php

namespace GraphQLTestClient;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var Client */
    protected $graphql;

    public function setUp(): void
    {
        parent::setUp();
        $this->graphql = new LaravelTestClient(
            $this->app,
            env('GRAPHQL_BASE_URL', '/graphql')
        );
    }
}
