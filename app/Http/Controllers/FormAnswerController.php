<?php

namespace App\Http\Controllers;

use App\Models\FormAnswer;
use App\Models\Formulir;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FormAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function responsePage(Request $request){
        $formulir = Formulir::where('uuid',$request->form_id)->first();
        
        return Inertia::render('Guest/ResponsePage',[
            'formulir' => $formulir
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            
            foreach ($data['content'] as $key => $value) {
                if (isset($value['answer']) && $value['tipe'] == 'file') {
                    Storage::putFileAs('public', $value['answer'], $value['answer']->getClientOriginalName());
                    $publicUrl = Storage::url('public/' . $value['answer']->getClientOriginalName());
                    
                    $value['path'] = $publicUrl;
                    unset($value['answer']);
                    
                    $data['content'][$key] = $value;
                }
            }
            $answerData = json_encode($data['content']);
            FormAnswer::create([
                'formulir_id' => $data['formulir_id'],
                'answer' => $answerData
            ]);
            return response()
            ->json([
                'message' => 'Berhasil mengirim jawaban anda'
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($form_id)
    {
        try {
            $formulirAnswer = FormAnswer::where('id',$form_id)
            ->whereHas('question',function($sub){
                $sub->where('user_id',Auth::user()->id);
            })->first();
            return Inertia::render('Client/Formulir/ViewAnswer',[
                'answerProp' => $formulirAnswer
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormAnswer $formAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormAnswer $formAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $form_id)
    {
        try {
            
            FormAnswer::find($form_id)->delete();
            return response()
            ->json([
                "message" => 'Berhasil menghapus data'
            ]);

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw $th;
        }
    }
}
