<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    //
    public function index(){


    //    $posts = Post::all(); //This is to show all the posts of the users!
    $posts = auth()->user()->posts()->paginate(5); //this shows only the post of the logged in user

        return view('admin.posts.index', ['posts'=>$posts]);
    }

    public function show(Post $post){

        return view('blog-post', ['post'=>$post]);

    }
    public function create(Post $post){

        return view('admin.posts.create');

    }

    public function store(){

        $this->authorize('create', Post::class);
//        auth()->user();
//        dd(request()->all());
        //this is to make a min of data required on the form
        $inputs = request()->validate([

            'title'=>'required|min:8|max:225',
            'post_image'=> 'file',
            'body'=> 'required'

        ]);

        if(request('post_image')){

            $inputs['post_image'] = request('post_image')->store('images');
        }
        auth()->user()->posts()->create($inputs);
        session()->flash('post-created-message', 'Post with title '. $inputs['title'] . ' was created');
        return redirect()->route('post.index');
    }

    public function edit(Post $post){

//        $this->authorize('view', $post);
//        if(auth()->user()->can('view',$post)){} // Another option you can use that you can pass with the View on the policy model

        return view('admin.posts.edit', ['post'=> $post]);

    }

    public function destroy(Post $post,Request $request){
        $this->authorize('delete', $post);
        $post->delete();
        $request->session()->flash('message', 'Post has been Obliterated');
        return back();

    }

    public function update(Post $post){

        $inputs = request()->validate([
            'title'=>'required|min:8|max:225',
            'post_image'=> 'file',
            'body'=> 'required'
        ]);

        if(request('post_image')){

            $inputs['post_image'] = request('post_image')->store('images');
        }
        $post->title = $inputs['title'];
        $post->body = $inputs['title'];

        //Policies and user authorization
        $this->authorize('update', $post);

        auth()->user()->posts()->save($post); // this to save as the user

        //to simply save
        //$post->save(); // OR ->UPDATE();

        session()->flash('post-updated-message', 'Post with title '. $inputs['title'] . ' was updated');
        return redirect()->route('post.index');

     }
}
