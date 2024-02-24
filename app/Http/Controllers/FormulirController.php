<?php

namespace App\Http\Controllers;

use App\Exports\ResponderExport;
use App\Models\FormAnswer;
use App\Models\Formulir;
use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
        $defaultImage = asset('storage/image/form/default_background.jpg');

        return Inertia::render(
            'Client/Formulir/Create',
            [
                'defaultImage'=> $defaultImage
            ]
        );
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
            $filename = 'default_background.jpg';
            if ($request->hasFile('image_background')) {
                $file = $data['image_background'];
                $moveFile = Storage::put('public/image/form',$file);
                $filename = basename($moveFile);
            }

            Formulir::create([
                'uuid' => $uuid,
                'user_id' => Auth::user()->id,
                'title' => $data['title'],
                'content' => json_encode(json_decode($data['content'])),
                'url' => $randomUrl,
                'image_background' => $filename
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

    public function exportExcel(Request $request){
        
        try {
            $now = date('dmY');
            $requestData = $request->validate([
                'id' => 'required|numeric'
            ]);

            $invoiceAnswer = FormAnswer::where('formulir_id',$requestData['id'])
            ->get();

            $data = array_map(function($item){
                $jsonData = json_decode($item['answer']);

                $answerArray = [];
                foreach ($jsonData as $key => $value) {
                    
                    if ($value->tipe != 'file') {
                        $answerArray[] = [
                            'kolom' => $value->kolom,
                            'answer' => $value->answer,
                        ];
                    }else{
                        $url = asset($value->path);

                        $answerArray[] = [
                            'kolom' => $value->kolom,
                            'answer' => $url,
                        ];
                    }
                }
                return $answerArray;
            },$invoiceAnswer->toArray());
            return Excel::download(new ResponderExport(collect($data)),"responder_$now.xlsx");
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()
            ->json([
                'message' => $th->getMessage()
            ], 400);
        }

    }
}
