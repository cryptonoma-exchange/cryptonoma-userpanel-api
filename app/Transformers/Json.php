<?php
namespace App\Transformers;
class Json
{
    public static function response($success=true,$data = null, $message = null)
    {
    	if($success){
    		$success = true;
    		$error = false;
    	}else{
    		$success = false;
    		$error = true;
    	}
        return [
            'success'  => $success,
            'error'  => $error,
            'result'  => $data,
            'message' => $message,
        ];
    }
}