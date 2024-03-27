<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateCustomerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function customer_creation()
    {
        $this->withoutExceptionHandling();

        $customerData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'document' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'user_type' => 'common',
        ];

        $response = $this->postJson('api/customers/create', $customerData);

        $response->assertStatus(201)->assertJson(static function (AssertableJson $json) use ($customerData) {
            $json->where('data.customer.first_name', $customerData['first_name'])
                 ->where('data.customer.last_name', $customerData['last_name'])
                 ->where('data.customer.document', $customerData['document'])
                 ->where('data.customer.email', $customerData['email'])
                 ->where('data.customer.user_type', $customerData['user_type'])
                 ->missing('data.customer.password')
                 ->etc();
        });

        $this->assertDatabaseHas('customers', [
            'email' => $customerData['email'],
            'document' => $customerData['document'],
        ]);
    }
}
