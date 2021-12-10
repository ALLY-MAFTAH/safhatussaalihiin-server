<?php

namespace App\Http\Controllers;

use App\Models\Month;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getAllPosts(Request $request)
    {
        $date = null;

        if ($request['date']) {
            $date = $request['date'] ??  null;
        }
        $posts = Post::where('deleted_at', null)->latest()->get();
        if ($date == null) {
            $filteredPosts = $posts;
        } else {
            $filteredPosts = $posts->filter(function ($post) use ($date) {
                return $post->date == $date;
            });
        }

        if (REQ::is('api/*'))
            return response()->json(['posts' => $posts], 200);
        return view('posts')->with(['posts' => $filteredPosts, 'date' => $date]);
    }

    // Get a single post
    public function getSinglePost($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => "Post not found"], 404);
        }
        return response()->json(['post' => $post], 200);
    }

    // Post post
    public function postPost(Request $request, $monthId)
    {
        $month = Month::find($monthId);

        if (!$month) return back()->with('message', 'Month not found');

        $this->file_path_1 = null;
        $this->file_path_2 = null;
        $this->file_path_3 = null;
        $this->file_path_4 = null;
        $this->file_path_5 = null;

        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'picture_file_1' => 'required',
            'video_file_1' => 'required',
            'date' => 'required',
            'title' => 'required | unique:posts',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('message', $validator->errors()->first());
        }

        if ($request->hasFile('picture_file_1')) {
            $this->file_path_1 = $request->file('picture_file_1')->store('posts');
        } else return back()->with('message', 'Add a picture_file_1');

        if ($request->hasFile('picture_file_2')) {
            $this->file_path_2 = $request->file('picture_file_2')->store('posts');
        } else return back()->with('message', 'Add a picture_file_2');

        if ($request->hasFile('picture_file_3')) {
            $this->file_path_3 = $request->file('picture_file_3')->store('posts');
        } else $this->file_path_3 = null;

        if ($request->hasFile('video_file_1')) {
            $this->file_path_4 = $request->file('video_file_1')->store('posts');
        } else return back()->with('message', 'Add a video_file_1');

        if ($request->hasFile('video_file_2')) {
            $this->file_path_5 = $request->file('video_file_2')->store('posts');
        } else $this->file_path_5 = null;


        $post = new Post();
        $post->date = $request->input('date');
        $post->title = $request->input('title');
        $post->picture_file_1 = $this->file_path_1;
        $post->picture_file_2 = $this->file_path_2;
        $post->picture_file_3 = $this->file_path_3;
        $post->video_file_1 = $this->file_path_4;
        $post->video_file_2 = $this->file_path_5;

        $month->posts()->save($post);

        if (REQ::is('api/*'))

            return response()->json(['post' => $post], 201);
        return back()->with('message', 'Post added successfully');
    }

    public function putPost(Request $request, $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        $this->file_path_1 = null;
        $this->file_path_2 = null;
        $this->file_path_3 = null;
        $this->file_path_4 = null;
        $this->file_path_5 = null;

        if ($request->hasFile('picture_file_1')) {
            $this->file_path_1 = $request->file('picture_file_1')->store('posts');
        } else $this->file_path_1 = $post->picture_file_1;

        if ($request->hasFile('picture_file_2')) {
            $this->file_path_2 = $request->file('picture_file_2')->store('posts');
        } else $this->file_path_2 = $post->picture_file_2;

        if ($request->hasFile('picture_file_3')) {
            $this->file_path_3 = $request->file('picture_file_3')->store('posts');
        } else $this->file_path_3 = $post->picture_file_3;

        if ($request->hasFile('video_file_1')) {
            $this->file_path_4 = $request->file('video_file_1')->store('posts');
        } else $this->file_path_4 = $post->video_file_1;

        if ($request->hasFile('video_file_2')) {
            $this->file_path_5 = $request->file('video_file_2')->store('posts');
        } else $this->file_path_5 = $post->video_file_2;


        $post->update([
            'date' => $request->input('date'),
            'title' => $request->input('title'),
            'picture_file_1' => $this->file_path_1,
            'picture_file_2' => $this->file_path_2,
            'picture_file_3' => $this->file_path_3,
            'video_file_1' => $this->file_path_4,
            'video_file_2' => $this->file_path_5,
        ]);

        $post->save();

        if (REQ::is('api/*'))
            return response()->json(['post' => $post], 200);
        return back()->with('message', 'Post edited successfully');
    }

    // Delete post
    public function deletePost($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post does not exist'], 204);
        }

        $post->delete();

        if (REQ::is('api/*'))
            return response()->json(['post' => 'Post deleted successfully'], 200);
        return back()->with('message', 'Post deleted successfully');
    }

    public function viewPictureFile1($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $post->picture_file_1);
        return response()->download($pathToFile);
    }
    public function viewPictureFile2($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $post->picture_file_2);
        return response()->download($pathToFile);
    }
    public function viewPictureFile3($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $post->picture_file_3);
        return response()->download($pathToFile);
    }
    public function viewVideoFile1($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $post->video_file_1);
        return response()->download($pathToFile);
    }
    public function viewVideoFile2($postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not exists'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $post->video_file_2);
        return response()->download($pathToFile);
    }

    // *****************
    // *****************
    // *****************

    public function getTodayPosts()
    {
        $posts = Post::all();

        if (REQ::is('api/*'))
            return response()->json(['posts' => $posts, 'posts' => $posts]);
        return view('today')->with(['posts' => $posts, 'posts' => $posts]);
    }
}
