<?php
    function display_format($number,$digit=8,$format=NULL){
        if($format ==""){
            $twocoin = sprintf('%.'.$digit.'f',$number);
        }elseif($format==0){
            $twocoin = number_format($number,$digit);
        }else{
            $twocoin = number_format($number,$digit,",",".");
        }
        return $twocoin;
    }   

    function ncAdd($value1,$value2,$digit=8){
        $value = bcadd(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
        //$value = display_format($value1 + $value2, $digit);
        return $value;
    }
    function ncSub($value1,$value2,$digit=8){
       $value = bcsub(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
        //$value = display_format($value1- $value2,$digit);
        return $value;
    }
    function ncMul($value1,$value2,$digit=8){
        $value = bcmul(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
        //$value = display_format($value1* $value2, $digit);
        return $value;
    }
    
    function ncDiv($value1,$value2,$digit=8){
        $value = bcdiv(sprintf('%.10f',$value1), sprintf('%.10f',$value2), $digit);
         //$value = display_format($value1* $value2, $digit);
        return $value;
    }
    function imgvalidaion($img)
    {
        $myfile = fopen($img, "r") or die("Unable to open file!");
        $value = fread($myfile,filesize($img));
        if (strpos($value, "<?php") !== false) {
            $img = 0;
        } 
        elseif (strpos($value, "<?=") !== false){
            $img = 0;
        }
        elseif (strpos($value, "eval") !== false) {
            $img = 0;
        }
        elseif (strpos($value,"<script") !== false) {
            $img = 0;
        }else{
            $img=1;
        }
        fclose($myfile);
        return $img;
    }
    function TransactionString($length = 64) {
        $str = substr(hash('sha256', mt_rand() . microtime()), 0, $length);
        return $str;
    }

    function uniqueIdGenerator()
    {
        $cleanNumber = preg_replace('/[^0-9]/', '', microtime(false));
        $id = base_convert($cleanNumber, 10, 36);
        return $id;
    }

    function seoUrl($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
    
    function crul($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array();
        $headers[] = "Accept: application/json, text/plain";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (curl_errno($ch)) {
            echo $result = 'Error:' . curl_error($ch);
        } else {
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return $result;
    }
    function humanTiming ($time)
    {
        $time = time() - $time; // to get the time since that moment
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'min',
            1 => 'sec'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
        }

    }
    function getCoinimg($coin){
        $image = \App\Models\Commission::where('source',$coin)->value('image');
        if(!$image){
            $image ="eth.svg";
        }
        return $image;
    }



function get_type($currency){
    $get_commission = App\Models\Commission::where('source', '=', $currency)->first();
    $get_type = "coin";
    if(is_object($get_commission))
    {           
        $get_type = $get_commission->type;
    }
    return $get_type;
}


    function keygenerate(){
        $key = md5(microtime().rand());
        return $key;
    }

    function pvtgenerate(){
        $activation = md5(uniqid(rand(), true));
        return $activation;
    }
    
  function convertTimeZone($date, $converted = false, $chart = false)
{
    //get user login
    $user_id = '';
    if(Auth::user())
    {
    $user_id = Auth::user()->id;
    }
    $curent_timezone = 'UTC';
    if($user_id != '')
    {
    $is_login = App\User::where('id', $user_id)->first();
    if(is_object($is_login)) {
    $curent_timezone = $is_login->timezone;
    if($curent_timezone == NULL || $curent_timezone == ''){
    $curent_timezone = 'UTC';
    }
    }
    }

    if(!$converted)
    {
    $date = new DateTime($date, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone($curent_timezone));
    $time = $date->format('d-m-Y H:i:s');
    }
    else if($chart)
    {
    $date = new DateTime($date, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone('UTC'));
    $date->modify('+1 day');
    $time = $date->format('Y-m-d');
    $time = strtotime($time)."000";
    }
    else if($converted == 'integer')
    {
    $date = new DateTime($date, new DateTimeZone($curent_timezone));
    $date->setTimezone(new DateTimeZone($curent_timezone));
    $time = $date->format('d-m-Y H:i:s');
    }
    else if($converted == 'time_only')
    {
    $date = new DateTime($date, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone($curent_timezone));
    $time = $date->format('H:i:s');
    }
    else if($converted == 'clock_time')
    {
    $date = new DateTime($date, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone($curent_timezone));
    $time = $date->format('Y/m/d H:i:s');
    }
    else
    {
    $date = new DateTime($date, new DateTimeZone('UTC'));
    $date->setTimezone(new DateTimeZone($curent_timezone));
    $time = $date->format('d-m-Y');
    }
    return $time;
}

  // p2p helper end

  function binanceMessage($response){
    $data = [
        "status" => true,
        "msg" => ""
    ];
    if($response == NULL){
        $data["status"] = false;
        $data["msg"] = "Price is too high, too low, and/or not following the tick size rule for the symbol.";
        return (object) $data;
    }
    if(isset($response["msg"])){
        $data["status"] = false;
        $msg = $response["msg"];
        if ("Filter failure: PRICE_FILTER" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Price is too high, too low, and/or not following the tick size rule for the symbol.";
        }else if ("Filter failure: PERCENT_PRICE" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Price is X% too high or X% too low from the average weighted price over the last Y minutes.";
        }else if ("Filter failure: PERCENT_PRICE_BY_SIDE" == $msg) {
            $data["status"] = false;
            $data["msg"] = "price is X% too high or Y% too low from the lastPrice on that side.";
        }else if ("Filter failure: LOT_SIZE" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Quantity is too high, too low, and/or not following the step size rule for the symbol.";
        }else if ("Filter failure: MIN_NOTIONAL" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Price * quantity is too low to be a valid order for the symbol.";
        }else if ("Filter failure: MAX_NUM_ORDERS" == $msg) {  
            $data["status"] = false;  	
            $data["msg"] = "Account has too many open orders on the symbol.";
        }else if ("Filter failure: MAX_ALGO_ORDERS" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Account has too many open stop loss and/or take profit orders on the symbol";
        }else if ("Filter failure: MAX_NUM_ICEBERG_ORDERS" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Account has too many open iceberg orders on the symbol.";
        }else if ("Filter failure: EXCHANGE_MAX_NUM_ORDERS" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Account has too many open orders on the exchange.";
        }else if ("Filter failure: EXCHANGE_MAX_ALGO_ORDERS" == $msg) {
            $data["status"] = false;
            $data["msg"] = "Account has too many open stop loss and/or take profit orders on the exchange.";
        } else {
            $data["status"] = false;
            $data["msg"] = $msg;
        }
    }
    return (object) $data;
}

function apiResponse($success = true, $message = "", $data = "")
{
    return response()->json([
        "result" => $data,
        "success" => $success,
        "message" => $message
    ]);
}

function rawQueryPagination($collection, $count, $perPage, $page)
{
    // $page = \Illuminate\Pagination\Paginator::resolveCurrentPage();
    return new \Illuminate\Pagination\LengthAwarePaginator($collection, $count, $perPage, $page, [
        'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
    ]);
}

function binance(){
    $liquidity = \App\Models\Liquidity::first();
    return new \Binance\API($liquidity->apikey,$liquidity->secretkey, $liquidity->testnet == 1 ? true : false);
}
?>