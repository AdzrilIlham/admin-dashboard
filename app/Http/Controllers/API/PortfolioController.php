<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AboutMeResource;
use App\Http\Resources\BlogResource;
use App\Models\AboutMe;
use App\Models\Blog;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Get About Me data.
     */
    public function aboutMe()
    {
        $aboutMe = AboutMe::first();

        if (!$aboutMe) {
            return response()->json([
                'success' => false,
                'message' => 'About Me data not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new AboutMeResource($aboutMe),
        ]);
    }

    /**
     * Get all projects.
     */
    public function projects()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $projects,
        ]);
    }

    /**
     * Get single project by ID.
     */
    public function projectDetail($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $project,
        ]);
    }

    /**
     * Get all skills.
     */
    public function skills()
    {
        $skills = Skill::orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $skills,
        ]);
    }

    /**
     * Get all published blogs.
     */
    public function blogs()
    {
        $blogs = Blog::published()
            ->latest()
            ->paginate(9);

        return response()->json([
            'success' => true,
            'data' => BlogResource::collection($blogs),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }

    /**
     * Get single blog by slug.
     */
    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->first();

        if (!$blog) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found',
            ], 404);
        }

        // Increment views
        $blog->incrementViews();

        return response()->json([
            'success' => true,
            'data' => new BlogResource($blog),
        ]);
    }

    /**
     * Get blog categories.
     */
    public function blogCategories()
    {
        $categories = Blog::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get blogs by category.
     */
    public function blogsByCategory($category)
    {
        $blogs = Blog::published()
            ->where('category', $category)
            ->latest()
            ->paginate(9);

        return response()->json([
            'success' => true,
            'data' => BlogResource::collection($blogs),
            'meta' => [
                'current_page' => $blogs->currentPage(),
                'last_page' => $blogs->lastPage(),
                'per_page' => $blogs->perPage(),
                'total' => $blogs->total(),
            ],
        ]);
    }
}