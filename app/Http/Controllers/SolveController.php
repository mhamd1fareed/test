<?php
namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Currency;

use Illuminate\Http\Request;

class SolveController extends Controller
{
    public function convert(Request $request)
    {
        // Validate the request data
        $request->validate([
            "from" => "required",
            "to" => "required",
        ]);

        // Find the first currency by abbreviation
        $first_currency = Currency::where(["abbreviation" => $request->from])->first();
        if (empty($first_currency)) {
            return response()->json([
                "status" => 0,
                "message" => "First currency not found"
            ]);
        }

        // Find the second currency by abbreviation
        $second_currency = Currency::where(["abbreviation" => $request->to])->first();
        if (empty($second_currency)) {
            return response()->json([
                "status" => 0,
                "message" => "Second currency not found"
            ]);
        }

        // Calculate the conversion rate
        $value = (float)($first_currency->toUSD) / ($second_currency->toUSD);


        // Format the result to 8 decimal places
        $formattedResult = number_format($value, 8);

        // Return a JSON response with the result
        return response()->json([
            "status" => 1,
            "result" => $formattedResult
        ]);
    }

    public function costInUSD(Request $request)
    {
        // Validate the request data
        $request->validate([
            "project" => "required"
        ]);

        // Find all costs related to the project
        $costs = Cost::where(["project" => $request->project])->get();

        // Calculate the total cost in USD
        $totalCost = 0;
        foreach ($costs as $cost) {
            $currency = $cost->currency;
            $costValue = $cost->cost;

            // Find the currency exchange rate
            $currencyExchange = Currency::where(["abbreviation" => $currency])->first();

            // Add the cost in USD to the total cost
            $totalCost += $costValue * $currencyExchange->toUSD;
        }

        // Return a JSON response with the total cost in USD
        return response()->json([
            "status" => 1,
            "result" => $totalCost
        ]);
    }


    public function costInAnyCurrency(Request $request)
    {
        // Validate the request data
        $request->validate([
            "project" => "required",
            "currency" => "required"
        ]);

        // Find all costs related to the project
        $costs = Cost::where(["project" => $request->project])->get();

        // Calculate the total cost in USD
        $totalCostInUSD = 0;
        foreach ($costs as $cost) {
            $currency = $cost->currency;
            $costValue = $cost->cost;

            // Find the currency exchange rate
            $currencyExchange = Currency::where(["abbreviation" => $currency])->first();

            // Add the cost in USD to the total cost in USD
            $totalCostInUSD += $costValue * $currencyExchange->toUSD;
        }

        // Find the currency exchange rate for the requested currency
        $requestedCurrencyExchange = Currency::where(["abbreviation" => $request->currency])->first();

        // Calculate the total cost in the requested currency
        $totalCost = (float)($totalCostInUSD) / ($requestedCurrencyExchange->toUSD);

        // Return a JSON response with the total cost in the requested currency
        return response()->json([
            "status" => 1,
            "result" => $totalCost
        ]);
    }
}
