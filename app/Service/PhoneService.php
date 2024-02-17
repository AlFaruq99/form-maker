<?php

namespace App\Service;

use App\InterFace\ServiceInterface;

class PhoneService implements ServiceInterface{
    
    public static function formatNumber(string $number = '') : string {
        
        $phoneNumber = preg_replace('/\D/', '', $number);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        return $phoneNumber;
    }

}