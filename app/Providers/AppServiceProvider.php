<?php

namespace App\Providers;

use App\Libraries\Binance;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

use App\Models\Socialmedia;
use App\Models\Commission;

use View;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use App\Libraries\BinanceClass;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("binance",function($app){
            $binance = new BinanceClass;
            return $binance->api;
        });
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $guard)
    {
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\p{L}\s]+$/u', $value); 
        });

        Validator::extend('only_numbers', function ($attribute, $value) {
            return preg_match('/^[0-9]+$/u', $value);
        });
        
        Validator::extend('is_png',function($attribute, $value, $params, $validator) {
            $image = base64_decode($value);
            $f = finfo_open();
            $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
            return $result == 'image/png';
        });


          Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
              return str_replace(':field', $parameters[0], 'Max amount is too low');
            });

        
            View::composer('*', function($view) use($guard) {

            $socialMedia  = Socialmedia::where('id', 1)->first();
            $coin_details = Commission::index();

            $view->with('socialMedia', $socialMedia)->with('coin_details', $coin_details);


        });

    }
}
