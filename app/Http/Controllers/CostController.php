<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cost;
use App\Models\Currency;
use App\Models\Project;

class CostController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'project' => 'required',
            'currency' => 'required',
            'cost' => 'required'
        ]);

        // Find the project by name
        $project = Project::where(["name" => $request->project])->first();
        if (empty($project)) { // Check if the project was not found
            $res = [
                'status' => 0,
                'message' => 'Project not found'
            ];
            return response($res);
        }

        // Find the currency by abbreviation
        $currency = Currency::where(["abbreviation" => $request->currency])->first();
        if (empty($currency)) { // Check if the currency was not found
            $res = [
                'status' => 0,
                'message' => 'Currency not found'
            ];
            return response($res);
        }

        // Check if a cost already exists for this project and currency
        $cost = Cost::where(['project' => $request->project, 'currency' => $request->currency])->first();
        if (!empty($cost)) { // If a cost already exists, return it
            $res = [
                'status' => 1,
                'data' => $cost
            ];
            return response($res);
        }

        // Create a new cost with the validated data
        $cost = Cost::create($data);

        // Return the new cost
        $res = [
            'status' => 1,
            'data' => $cost
        ];
        return response($res);
    }
}
