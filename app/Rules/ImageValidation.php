<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $message;
    public function __construct($message = "Invalid image")
    {
        $this->message = $message;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $myfile = fopen($value->getRealPath(), "r");
            $value = fread($myfile, filesize($value->getRealPath()));
            if (strpos($value, "<?php") !== false) {
                $img = 0;
            } elseif (strpos($value, "eval") !== false) {
                $img = 0;
            } elseif (strpos($value, "<script") !== false) {
                $img = 0;
            } else {
                $img = 1;
            }
            fclose($myfile);
            if($img == 1){
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}