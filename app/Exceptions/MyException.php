<?php

namespace App\Exceptions;

use Exception;

class MyException extends Exception
{
    public function render($request){
        return response()->json(['error_code'=>4008,'msg'=>$this->message],$this->code);
    }  
}
