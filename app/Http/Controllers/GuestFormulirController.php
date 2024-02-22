<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GuestFormulirController extends Controller
{
    public function formulir($form_id){
        try {
            $formulir = Formulir::where('uuid',$form_id)
            ->first();
            $imageUrl = asset('storage/image/form/'.$formulir->image_background);
            $formulir->image_background = $imageUrl;
            $formulir->content = json_decode($formulir->content);
            return Inertia::render('Guest/FormulirView',[
                'formulir' => $formulir
            ]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    
}
