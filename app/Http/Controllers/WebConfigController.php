<?php

namespace App\Http\Controllers;

use App\Service\EnvService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebConfigController extends Controller
{
    public function update(Request $request){
        try {

            if ($request->hasFile('logo')) {
                $file = $request->logo;
                $file->move(public_path('storage/'),'webLogo.png');
            }

            if ($request->name != null) {
                DB::table('web_config')
                ->insert([
                    'web_name' => $request->name
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getWebName(){
        $webName = DB::table('web_config')
        ->first();
        return $webName->web_name??'Form Maker';
    }
}
