<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'name' => 'required|unique:projects',
            'description' => 'required|string'
        ]);

        // Create a new project with the validated data
        $project = Project::create($data);

        // Return a success response
        $res = [
            'status' => 1,
            'message' => 'Project added successfully'
        ];
        return response($res);
    }
}
