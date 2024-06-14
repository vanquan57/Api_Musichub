<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Comments;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function getAllCommentSong(Request $request){
        Carbon::setLocale('vi');
        $comments = Comment::where('songId',$request->input('songId'))->get();
        $commentsResult = $comments->map(function($comment){
            $user = User::find($comment->userId);
            $timeCreated = Carbon::parse($comment->created_at);
            $currentTime = Carbon::now();
            return [
                'id'=>$comment->id,
                'content'=>$comment->comment,
                'date'=> $timeCreated->diffForHumans($currentTime),
                'user' => $user
            ];
        });
        return response()->json($commentsResult);
    }
    public function addComment(Request $request){
        Carbon::setLocale('vi');

        $user = User::find($request->input('userId'));
        $comment = Comment::create([
            'songId' =>  $request->input('songId'),
            'userId' => $request->input('userId'),
            'comment' => $request->input('content')
        ]);
       if($comment){
        
        $timeCreated = Carbon::parse($comment->created_at);
        $currentTime = Carbon::now();
           return response()->json([
               'id'=>$comment->id,
               'content'=>$comment->comment,
               'date'=> $timeCreated->diffForHumans($currentTime),
               'user' => $user
           ]);
        }
    }
}
