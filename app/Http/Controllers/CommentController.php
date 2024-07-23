<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'analysis_id' => 'required|exists:analyses,id',
            'dataset_id' => 'required|exists:datasets,id',
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'analysis_id' => $request->analysis_id,
            'dataset_id' => $request->dataset_id,
        ]);

        return redirect()->route('datasets.show', $request->dataset_id)
                         ->with('success', 'Comment submitted successfully.');
    }
}
