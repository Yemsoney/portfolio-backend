<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectApiController extends Controller
{
    /**
     * Display a listing of projects
     */
    public function index()
    {
        $projects = Project::latest()->get();
        
        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }
}