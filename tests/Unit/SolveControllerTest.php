<?php

use App\Http\Controllers\SolveController;
use App\Models\Cost;
use App\Models\Currency;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tests\TestCase;

class SolveControllerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions, WithoutMiddleware;

    public function testConvert()
{
    // Mock the request data
    $requestData = [
        "from" => "USD",
        "to" => "EUR",
    ];
    $request = new Request($requestData);

    // Mock the first currency model
    $firstCurrency = Mockery::mock(Currency::class);
    $firstCurrency->toUSD = 1.0;

    // Mock the second currency model
    $secondCurrency = Mockery::mock(Currency::class);
    $secondCurrency->toUSD = 0.85;

    // Mock the Currency model's where and first methods
    Currency::shouldReceive('where')->with(["abbreviation" => "USD"])->andReturnSelf();
    Currency::shouldReceive('first')->andReturn($firstCurrency);
    Currency::shouldReceive('where')->with(["abbreviation" => "EUR"])->andReturnSelf();
    Currency::shouldReceive('first')->andReturn($secondCurrency);

    // Make the request to the controller method
    $controller = new SolveController();
    $response = $controller->convert($request);

    // Assert the response
    $expectedResult = [
        "status" => 1,
        "result" => "1.17647059"
    ];
    $this->assertEquals($expectedResult, $response->getData(true));
}

public function testCostInUSD()
{
    // Mock the request data
    $requestData = [
        "project" => "Project A",
    ];
    $request = new Request($requestData);

    // Mock the cost models
    $costs = [
        new Cost(['currency' => 'USD', 'cost' => 100]),
        new Cost(['currency' => 'EUR', 'cost' => 200]),
    ];

    // Mock the Currency model's where and first methods
    Currency::shouldReceive('where')->with(["abbreviation" => "USD"])->andReturnSelf();
    Currency::shouldReceive('first')->andReturnSelf();
    Currency::shouldReceive('where')->with(["abbreviation" => "EUR"])->andReturnSelf();
    Currency::shouldReceive('first')->andReturnSelf();

    // Mock the Cost model's where and get methods
    Cost::shouldReceive('where')->with(["project" => "Project A"])->andReturnSelf();
    Cost::shouldReceive('get')->andReturn(collect($costs));

    // Make the request to the controller method
    $controller = new SolveController();
    $response = $controller->costInUSD($request);

    // Assert the response
    $expectedResult = [
        "status" => 1,
        "result" => 500,
    ];
    $this->assertEquals($expectedResult, $response->getData(true));
}

public function testCostInAnyCurrency()
{
    // Mock the request data
    $requestData = [
        "project" => "Project B",
        "currency" => "EUR",
    ];
    $request = new Request($requestData);

    // Mock the cost models
    $costs = [
        new Cost(['currency' => 'USD', 'cost' => 100]),
        new Cost(['currency' => 'EUR', 'cost' => 200]),
    ];

    // Mock the Currency model's where and first methods
    Currency::shouldReceive('where')->with(["abbreviation" => "USD"])->andReturnSelf();
    Currency::shouldReceive('first')->andReturnSelf();
    Currency::shouldReceive('where')->with(["abbreviation" => "EUR"])->andReturnSelf();
    Currency::shouldReceive('first')->andReturnSelf();

    // Mock the Cost model's where and get methods
    Cost::shouldReceive('where')->with(["project" => "Project B"])->andReturnSelf();
    Cost::shouldReceive('get')->andReturn(collect($costs));

    // Make the request to the controller method
    $controller = new SolveController();
    $response = $controller->costInAnyCurrency($request);

    // Assert the response
    $expectedResult = [
        "status" => 1,
        "result" => 600,
    ];
    $this->assertEquals($expectedResult, $response->getData(true));
}

}
