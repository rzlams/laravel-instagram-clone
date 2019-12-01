<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Image;
use App\Comment;
use App\Like;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
    	return view('image.create');
    }

    public function save(Request $request){
	    $validate = $this->validate($request, [
	    	'image_path' => 'required|image',
	        'description' => 'required'
	    ]);

    	$image_path = $request->file('image_path');
    	$description = $request->input('description');

    	$image = new Image();
    	$image->user_id = \Auth::user()->id;
    	$image->description = $description;

    	if($image_path){
    		// Asignar nombre unico con el timestamp actual como prefijo
    		$image_path_name = time() . $image_path->getClientOriginalName();
    		// Guardar en la carpeta (storage/app/user)
    		Storage::disk('images')->put($image_path_name, File::get($image_path));
    		// Seteo el nombre de la imagen en el objeto
    		$image->image_path = $image_path_name;
    	}

    	$image->save();

    	return redirect()->route('home')->with([
    		'message' => 'Imagen subida correctamente'
    	]);
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }

    public function detail($id){
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && ($image->user_id == $user->id)){
            // Borra comentarios asociados
            if($comments && count($comments) > 0){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            // Borra likes asociados
            if($likes && count($likes) > 0){
                foreach($likes as $like){
                    $like->delete();
                }
            }
            // Elimina fichero de imagen
            Storage::disk('images')->delete($image->image_path);
            //Elimina registro de imagen
            $image->delete();

            $message = array('message' => 'La imagen se ha borrado correctamente');
        } else{
            $message = array('message' => 'La imagen no se ha borrado');
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user_id == $user->id){
            return view('image.edit', ['image' => $image]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){

        $validate = $this->validate($request, [
            'image_path' => 'image',
            'description' => 'required'
        ]);

        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        $image = Image::find($image_id);
        $image->description = $description;

        if($image_path){
            // Asignar nombre unico con el timestamp actual como prefijo
            $image_path_name = time() . $image_path->getClientOriginalName();
            // Guardar en la carpeta (storage/app/user)
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            // Seteo el nombre de la imagen en el objeto
            $image->image_path = $image_path_name;
        }

        $image->update();

        return redirect()->route('image.detail', ['id' => $image_id])->with(['message' => 'Imagen actualizada exitosamente']);

    }
}