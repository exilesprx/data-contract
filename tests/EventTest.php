<?php

namespace Tests;

use Tests\Helpers\UserCreatedEvent;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    /** @test */
    public function it_expects_cache_to_have_definitions()
    {
        Cache::shouldReceive("rememberForever")
        ->andReturn(
            json_decode(
                file_get_contents(UserCreatedEvent::getDataContractDefinitionLocation()),
                true
            )
        );

        $cache = UserCreatedEvent::getDataContractDefinitions();

        $this->assertTrue(is_array($cache));

        $this->assertArrayHasKey('properties', $cache);

        $this->assertArrayHasKey('name', Arr::get($cache, 'properties'));

        $this->assertArrayHasKey('email', Arr::get($cache, 'properties'));

        $this->assertArrayHasKey('password', Arr::get($cache, 'properties'));

        $this->assertArrayHasKey('country', Arr::get($cache, 'properties'));

        $this->assertArrayHasKey('company', Arr::get($cache, 'properties'));
    }

    /** @test */
    public function it_expects_user_event_to_pass()
    {
        UserCreatedEvent::fromArray(
            $this->getTestData()
        );
    }

    /** @test */
    public function it_expects_a_user_name_assertion_to_fail()
    {
        $this->expectException(ExpectationFailedException::class);

        UserCreatedEvent::fromArray(
            $this->getTestData(['name'])
        );
    }

    /** @test */
    public function it_expects_all_properties_to_be_set()
    {
        $data = array_merge(
            $this->getTestData(),
            [
                'country' => "CA"
            ]
        );

        $event = UserCreatedEvent::fromArray($data);

        $this->assertEquals(Arr::get($data, 'name'), $event->getName());

        $this->assertEquals(Arr::get($data, 'email'), $event->getEmail());

        $this->assertEquals(Arr::get($data, 'password'), $event->getPassword());

        $this->assertEquals(Arr::get($data, 'country'), $event->getCountry());
    }

    /** @test */
    public function it_expects_country_to_be_the_default()
    {
        Cache::shouldReceive("rememberForever")
            ->andReturn(
                json_decode(
                    file_get_contents(UserCreatedEvent::getDataContractDefinitionLocation()),
                    true
                )
            );

        $cache = UserCreatedEvent::getDataContractDefinitions();

        $event = UserCreatedEvent::fromArray(
            $this->getTestData()
        );

        $this->assertEquals(Arr::get($cache, 'properties.country.default'), $event->getCountry());
    }

    /** @test */
    public function it_expects_company_to_be_null()
    {
        $event = UserCreatedEvent::fromArray(
            $this->getTestData()
        );

        $this->assertNull($event->getCompany());
    }

    /** @test */
    public function it_expects_company_to_be_set()
    {
        $data = array_merge(
            $this->getTestData(),
            [
                "company" => "Test Inc."
            ]
        );

        $event = UserCreatedEvent::fromArray($data);

        $this->assertEquals(Arr::get($data, "company"), $event->getCompany());
    }

    private function getTestData(array $itemsToRemove = []) : array
    {
        $data = [
            'name' => "Tester",
            'email' => "test@test.com",
            'password' => "1aB%tuperT2$#",
        ];

        return array_filter(
            $data,
            function($item, $key) use ($itemsToRemove) {
                if (! in_array($key, $itemsToRemove)) {
                    return true;
                }
                return false;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }
}