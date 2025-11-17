<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function show()
    {
        return About::first();
    }

    public function update(Request $request)
    {
        $about = About::first() ?? new About();

        if ($request->hasFile('image')) {
            $about->image = $request->file('image')->store('about', 'public');
        }

        $about->title = $request->title;
        $about->description = $request->description;
        $about->save();

        return response()->json(['message' => 'About updated', 'data' => $about]);
    }
}

