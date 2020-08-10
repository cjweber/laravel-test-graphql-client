# Laravel GraphQL Test Client
This is a package which allows you to create integration tests against your GraphQL API easily and quickly.

## Requirements
```
1. Laravel 6.0 + / PHP 7.0 +
2. PHPUnit 8.0 +
3. GraphQL setup on your Laravel server, via https://github.com/rebing/graphql-laravel or other
```

## What's inside
```
1. Basic GraphQL Client
2. Extension of TestCase which allows for access to the GraphQL client within your tests
```

## Installation
`composer require cjweber/laravel-test-graphql-client --dev`

## Usage
```
1. Extend the package TestCase for your feature test in order to leverage the included GraphQL Client
2. Make queries against your GraphQL by constructing a Query object and then passing it to the `graphql` property on your TestCase class
3. Use the `assertGraphQlFields` function in the package to test that the server returned the fields you expect. You can also do any other assertions that come with PHPUnit against the response data returned by the client.
```

## Example
```
<?php

namespace Tests\Feature\GraphQL;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use GraphQLTestClient\TestCase;
use GraphQLTestClient\Field;
use GraphQLTestClient\Query;

use App\Project;
use App\User;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp() :void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    /**
     * Test that a User can create a Project
     *
     * @return void
     */
    public function testCreateProject()
    {
        $this->actingAs($this->user, 'api');

        $description = $this->faker->paragraph;
        $name = $this->faker->sentence;

        $query = new Query(
            'project',
            [
                'input' => [
                    'name' => $name,
                    'description' => $description,
                ],
            ],
            [
                new Field('uuid'),
                new Field('description'),
                new Field('name'),
            ]
        );

        $result = $this->graphql->mutate($query)->getData();

        $this->graphql->assertGraphQlFields($result, $query);
        $createdProject = Project::where('uuid', $result['uuid'])->first();
        $this->assertEquals($createdProject->name, $name);
        $this->assertEquals($createdProject->description, $description);
        $this->assertEquals($result['name'], $name);
        $this->assertEquals($result['description'], $description);
    }
}
```

## Thanks
Christian Goltz for providing the much of the base GraphQL client code in https://github.com/christiangoltz/graphql-client-php

## Feedback / Changes
Feel free to email me at christopher.j.weber@protonmail.com , create an issue, and/or submit a PR if you want to make any improvements or changes.