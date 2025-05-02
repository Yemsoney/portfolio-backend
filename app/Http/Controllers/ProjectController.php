<?php

// File: app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|max:10240', // 10MB max
            'project_url' => 'nullable|url',
            'technologies' => 'nullable|string',
        ]);

        // Handle Cloudflare image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            
            // Upload to Cloudflare R2 Storage
            $imageUrl = $this->uploadToCloudflare($image, $imageName);
        }

        // Process technologies as array
        $technologies = !empty($validated['technologies']) 
            ? explode(',', $validated['technologies']) 
            : [];

        // Create project
        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image_url' => $imageUrl ?? null,
            'project_url' => $validated['project_url'] ?? null,
            'technologies' => $technologies,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:10240', // 10MB max
            'project_url' => 'nullable|url',
            'technologies' => 'nullable|string',
        ]);

        // Handle Cloudflare image upload if new image provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image_url) {
                $this->deleteFromCloudflare($project->image_url);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            
            // Upload to Cloudflare R2 Storage
            $imageUrl = $this->uploadToCloudflare($image, $imageName);
            $project->image_url = $imageUrl;
        }

        // Process technologies as array
        $technologies = !empty($validated['technologies']) 
            ? explode(',', $validated['technologies']) 
            : [];

        // Update project
        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'project_url' => $validated['project_url'] ?? null,
            'technologies' => $technologies,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Delete image from Cloudflare if exists
        if ($project->image_url) {
            $this->deleteFromCloudflare($project->image_url);
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Upload file to Cloudflare R2 Storage
     */
    private function uploadToCloudflare($file, $fileName)
    {
        // Configure the Cloudflare R2 disk in config/filesystems.php first
        $path = Storage::disk('cloudflare')->putFileAs('projects', $file, $fileName);
        
        // Generate the public URL (depends on your Cloudflare setup)
        $baseUrl = config('filesystems.disks.cloudflare.url');
        return $baseUrl . '/' . $path;
    }

    /**
     * Delete file from Cloudflare R2 Storage
     */
    private function deleteFromCloudflare($fileUrl)
    {
        // Extract path from URL
        $baseUrl = config('filesystems.disks.cloudflare.url');
        $path = str_replace($baseUrl . '/', '', $fileUrl);
        
        // Delete file
        Storage::disk('cloudflare')->delete($path);
    }
    public function __construct()
    {
        $this->middleware('auth'); // Add authentication middleware
    }

}
