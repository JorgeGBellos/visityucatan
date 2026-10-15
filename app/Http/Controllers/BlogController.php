<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function show(BlogPost $post): View
    {
        abort_unless($post->is_published, 404);

        return view('pages.blog-show', [
            'post' => $post,
        ]);
    }
}
