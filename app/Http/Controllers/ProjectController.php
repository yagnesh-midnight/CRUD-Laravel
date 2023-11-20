<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function getallprojects(Request $request)
    {
        if (!$request->has('id')) {
            return response()->json(Project::all());
        } else {
            $projectId = $request->input('id');
            $project = Project::findOrFail($projectId);
            return response()->json($project);
        }
    }

    public function addproject(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $project = Project::create([
            'name' => $request->input('name'),
        ]);

        if ($project) {
            return response()->json(['status' => 200, 'data' => "Project Added Sucessfully"]);
        } else {
            return response()->json(['status' => 400, 'error' => "Something Went Wrong."], 400);
        }
    }

    public function updateproject(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:projects,id',
            'name' => 'required|max:255',
        ]);

        $project = Project::findOrFail($request->input('id'));
        $project->update([
            'name' => $request->input('name'),
        ]);

        if ($project) {
            return response()->json(['status' => 200, 'data' => "Project Updated Sucessfully"]);
        } else {
            return response()->json(['status' => 400, 'error' => "Something Went Wrong."], 400);
        }
    }

    public function deleteproject(Request $request)
    {
    $projectId = $request->input('id');

    // Check if the project with the given ID exists
    $project = Project::findOrFail($projectId);

    // Delete the project
    $stat = $project->delete();

    if ($stat) {
        return response()->json(['status' => 200, 'data' => "Project Deleted Sucessfully"]);
    } else {
        return response()->json(['status' => 400, 'error' => "Something Went Wrong."], 400);
    }
    }
}
