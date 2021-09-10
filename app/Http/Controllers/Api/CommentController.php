<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(){
        return Comment::all();
    }

    public function getPostComments($id){
        return Comment::where('post_id', $id)->get();
    }
    
    public function createPostComment(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'content' => ['required', 'string', 'max:500'],
        ]);
        if($validator->fails()){
            return json_decode($validator->errors()->toJson());
        }
        $comment = Comment::create([
            'author' => Auth::id(),
            'content' => $request->content,
            'post_id' => $id,
        ]);
        if($comment){
            return ['success' => 'Commented in post successfully!'];
        }else{
            return ['fail' => 'Something went wrong!'];
        }
    }

    public function show($id){
        $comment = Comment::find($id);
        if($comment){
            return $comment;
        }else{
            return['fail' => 'Comment requested not found!'];
        }
    }   

    public function update(Request $request, $id){
        $comment = Comment::find($id);
        if($comment){
            $validator = Validator::make($request->all(), [
                'content' => ['required', 'string', 'max:500'],
            ]);
            if($validator->fails()){
                return json_decode($validator->errors()->toJson());
            }
            $comment->update(['content' => $request->content]);
            return ['success' => 'Comment updated successfully!'];
        }else{
            return ['fail' => 'Comment requested not found!'];
        }
    }

    public function destroy($id){
        if(Comment::find($id)){
            Comment::destroy($id);
            return ['success' => 'Comment deleted successfully!'];
        }else{
            return ['fail' => 'Comment requested not found!'];
        }
    }
}
