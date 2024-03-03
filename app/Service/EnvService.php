<?php
namespace App\Service;
use App\Interface\ServiceInterface;
use Dotenv\Repository\Adapter\ImmutableWriter;
use Dotenv\Repository\AdapterRepository;
use Illuminate\Support\Env;


class EnvService implements ServiceInterface{
    public static function set(String $key, String $value){
        
        $path = app()->environmentFilePath();
        $value = str_replace(' ', '_', $value);
        $escaped = preg_quote('='.env($key), '/');

        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}