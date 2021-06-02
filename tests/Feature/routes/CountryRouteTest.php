<?php

namespace Tests\Feature\routes;

use App\Enums\ResponseEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryRouteTest extends TestCase
{
    protected $borders = "col;no;ee";

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function getAllError()
    {
        $response = $this->getJson('api/v1/countries', $this->authHeader);

        $response->assertStatus(500);
    }

    /** @test */
    public function getAllNoFilter()
    {
        $response = $this->getJson('api/v1/countries?typeSearch=0', $this->authHeader);

        $response->assertStatus(200);
    }

    /** @test */
    public function getAllByName()
    {
        $response = $this->getJson('api/v1/countries?typeSearch=1&term=Brasil', $this->authHeader);

        $response->assertStatus(200);
    }

    /** @test */
    public function getAllByCode()
    {
        $response = $this->getJson('api/v1/countries?typeSearch=2&term=BRA', $this->authHeader);

        $response->assertStatus(200);
    }

    /** @test */
    public function getAllByCurrencie()
    {
        $response = $this->getJson('api/v1/countries?typeSearch=3&term=cop', $this->authHeader);

        $response->assertStatus(200);
    }


    /** @test */
    public function showCountrySuccess()
    {
        $response = $this->getJson('api/v1/countries/BRA', $this->authHeader);

        $response->assertStatus(200);
    }

    /** @test */
    public function showCountryError()
    {
        $response = $this->getJson('api/v1/countries/B12', $this->authHeader);

        $response->assertStatus(500);
    }

    /** @test */
    public function listBordersOfCountrySuccess()
    {
        $uri = 'api/v1/get-borders?borders=' . $this->borders;
        $response = $this->getJson($uri, $this->authHeader);

        $response->assertStatus(200);
    }

    /** @test */
    public function listBordersOfCountryError()
    {
        $uri = 'api/v1/get-borders';
        $response = $this->getJson($uri, $this->authHeader);

        $response->assertStatus(500);
    }
}
