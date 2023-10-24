<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ArticleStoreValidation;
use App\Http\Requests\ArticleUpdateValidation;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
//opslag
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
//policy
use App\Policies\AdminPolicy;

class PostController extends Controller
{
    public function index()
    {

        $today = Carbon::today();
        $posts = Post::whereDate('publication_date', '<=', $today)
                 ->orderBy('created_at', 'desc') 
                 ->get();
        $categories = Category::get();

        return view("articles.index", compact("posts", "categories"));
    }


    public function create()
    {
        $this->authorize('isAdmin', User::class);
        $categories = Category::all();
        return view("articles.create", compact('categories'));
    }

    public function store(ArticleStoreValidation $request, Post $post)
    {
        $post->title = $request->title;
        $post->introduction = $request->introduction;
        $post->content = $request->content;
        $post->category_id = $request->category_id; 
        $post->publication_date = $request->publication_date;

        $post->save();

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete('articles/' . $post->id . '/' . $post->image);
            }
            $imageName = $post->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('articles/' . $post->id , $imageName);
            $post->image = $imageName;
        }

        $post->save();
    

        return redirect()->route("dashboard")->with('success', 'Artikel aangemaakt');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view("articles.edit", compact('post', 'categories'));
    }

    public function update(ArticleUpdateValidation $request, Post $post)
    {
        $post->title = $request->title;
        $post->introduction = $request->introduction;
        $post->content = $request->content;
        $post->category_id = $request->category_id; 
        $post->publication_date = $request->publication_date;

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::delete('articles/' . $post->id . '/' . $post->image);
            }
            $imageName = $post->id . '.' . $request->file('image')->extension();
            $request->file('image')->storeAs('articles/' . $post->id , $imageName);
            $post->image = $imageName;
        } elseif ($request->input('delete_image')) {
            if ($post->image) {
                Storage::delete('articles/' . $post->id . '/' . $post->image);
                $post->image = "images/articles/placeholder.png";
            }
        }

        $post->save();

        return redirect()->route("dashboard")->with('success', 'Artikel aangepast');
    }

    public function destroy(Post $post)
    {

        if ($post->image && $post->image != 'images/articles/placeholder.png') {
            Storage::delete('articles/' . $post->id . '/' . $post->image);
        }

        $post->delete();

        return redirect(route("dashboard"))->with('success', 'Artikel verwijderd');
    }

    public function dashboardAll()
    {
        // je moet de paginate aantal ook aanpassen bij web.php /dashboard
        $posts = Post::orderBy('created_at', 'desc')->paginate(5);
        $categories = Category::all();
        return view("articles.dashboard", compact("posts", "categories"));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $posts = Post::orderBy('created_at', 'desc')
        ->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('title', 'like', "%$query%")
                ->orWhereHas('category', function ($innerQuery) use ($query) {
                    $innerQuery->where('name', 'like', "%$query%");
                });
        })
        ->paginate(5)
        ->withQueryString(); // zorgt ervoor dat de zoekopdracht in de url blijft staan bljkbaar
    
        return view('articles.dashboard', compact('posts', 'query'));
    }
}
