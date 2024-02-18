<?php

namespace App\Http\Controllers;

use App\Models\FormAnswer;
use App\Models\Formulir;
use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Illuminate\Support\Str;

use function Laravel\Prompts\search;

class FormulirController extends Controller
{
    public function index(){
        return Inertia::render('Client/Formulir/Index');
    }

    public function FormulirData(Request $request){
        $length = $request->length;
        $search = $request->search != '' || isset($request->search) ? $request->search : null;

        $userId = Auth::user()->id;
        $formulir = Formulir::where('user_id',$userId)->with('shortLink')
        ->when($search,function($sub) use($search){
            $sub->where('title','ilike',"%$search%");
        })
        ->paginate($length)->onEachSide(1);
        return response()
        ->json($formulir);
    }

    public function CreateForm(){
        return Inertia::render('Client/Formulir/Create');
    }

    public function Create(Request $request){
        try {
            $data = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image_background' => 'nullable',
                'image_color' => 'nullable',
            ]);

            $uuid = Str::uuid();
            $randomUrl = env('APP_URL').'/'.Str::random(6);
            
            Formulir::create([
                'uuid' => $uuid,
                'user_id' => Auth::user()->id,
                'title' => $data['title'],
                'content' => json_encode($data['content']),
                'url' => $randomUrl
            ]);

            ShortLink::create([
                'original_url' => route('guest.formulir',['form_id'=>$uuid]),
                'short_url' => $randomUrl
            ]);

            return response()
            ->json([
                "message" => 'Berhasil membuat formulir'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function ViewForm($uuid){
        try {
            $formulir = Formulir::where('uuid',$uuid)->first();
            $formulir->content = json_decode($formulir->content);
            return Inertia::render('Client/Formulir/ViewFormulir',[
                'formulir' => $formulir
            ]);
        } catch (\Throwable $th) {
            abort(404);
        }
    }

    public function delete($formId){
        try {
            Formulir::find($formId)
            ->delete();
            return response()
            ->json([
                "message" => 'Berhasil menghapus data'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }

    public function responderPage(){
        return Inertia::render('Client/Formulir/Responder');
    }

    public function responderList(Request $request){
        try {
            $length = $request->length;
            $user = Auth::user();
            if (!isset($user)) {
                abort(404);
            }

            $formulir = Formulir::where('user_id',$user->id)
            ->first();

            $answerData = FormAnswer::where('formulir_id',$formulir->id)
            ->paginate($length);

            return response()
            ->json($answerData);
        } catch (\Throwable $th) {
            return abort(404);
        }
        
    }
}
