<?php

namespace App\Http\Controllers;

use App\Service\EnvService;
use Illuminate\Http\Request;

class WebConfigController extends Controller
{
    public function update(Request $request){
        try {

            if ($request->hasFile('logo')) {
                $file = $request->logo;
                $file->move(public_path('storage/'),'webLogo.png');
            }

            if ($request->name != null) {
                EnvService::set('APP_NAME',"$request->name");
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
