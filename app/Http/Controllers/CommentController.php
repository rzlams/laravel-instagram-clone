<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function save(Request $request){
    	$validate = $this->validate($request, [
    		'image_id' => 'integer|required',
    		'content' => 'string|required'
    	]);

    	$content = $request->input('content');
    	$image_id = $request->input('image_id');
    	$user_id = \Auth::user()->id;

    	$comment = new Comment();
    	$comment->user_id = $user_id;
    	$comment->image_id = $image_id;
    	$comment->content = $content;
    	$comment->save();

    	return redirect()->route('image.detail', ['id' => $image_id])->with([
    			'message' => 'Comentario publicado correctamente']);

    }

    public function delete($id){
    	// Datos del usuario logueado
    	$user = \Auth::user();
    	// Conseguir objeto del comentario
    	$comment = Comment::find($id);
    	// Comprobar si soy el dueño del comentario o de la publicacion
    	if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
    		$comment->delete();

    		return redirect()->route('image.detail', ['id' => $comment->image_id])->with(['message' => 'Comentario eliminado correctamente']);
    	} else{
    		return redirect()->route('image.detail', ['id' => $comment->image_id])->with(['message' => 'El comentario no e pudo eliminar']);
    	}
    }
}
