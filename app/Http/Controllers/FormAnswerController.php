<?php

namespace App\Http\Controllers;

use App\Models\FormAnswer;
use App\Models\Formulir;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
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
                if (isset($value['asnwer']) && $value['answer'] instanceof UploadedFile) {
                    $value['answer']->move(storage_path('upload/guestfile'), $value['answer']->getClientOriginalName());
                    $value['path'] = 'upload/guestfile/'.$value['answer']->getClientOriginalName().date('YmdHis');
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
    public function show(FormAnswer $formAnswer)
    {
        //
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
    public function destroy(FormAnswer $formAnswer)
    {
        //
    }
}
