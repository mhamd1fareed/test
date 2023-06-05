<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required',
            'abbreviation' => 'required|unique:currencies',
            'toUSD' => 'required'
        ]);

        // Create a new currency with the validated data
        $currency = Currency::create($data);

        // Return a success response
        $res = [
            'status' => 1,
            'message' => 'Currency added successfully'
        ];
        return response($res);
    }
}
