<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // User create comment
    public function store(Request $request)
    {
        Comment::create([
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
            'is_admin' => false
        ]);

        return response()->json(['message' => 'Comment added']);
    }

    // Admin reply
    public function reply(Request $request, $id)
    {
        Comment::create([
            'name' => "Admin",
            'email' => null,
            'comment' => $request->comment,
            'parent_id' => $id,
            'is_admin' => true
        ]);

        return response()->json(['message' => 'Reply sent']);
    }

    // get nested comments
    public function index()
    {
        return Comment::whereNull('parent_id')
            ->with('replies')
            ->get();
    }
}
