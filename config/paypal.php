<?php 


return [ 
/** set your paypal credential **/
/*'client_id' =>'AfKkAKzHnjLIwx4CuFscHq4jxG-4E3n8xdGtCiClb_r3Ehx00BwXTwGQmCxBwrcOc6_6Th3X7Dbo8ot0',
'secret' =>'EOssuMxsHx9M5sGhIX496emr-3QshKJ2tU3PcGJ1M4bV_rGluGPAF2psqUEM6D_kJMVlNFKTE2cpDDA1',*/

//test
'client_id' =>'AZ_OwZqltKkdAFwhrBA5bBbiR-EfvNcr78_lRE0PXA2RtC7WwkVF5qvis1vkNc4ffMp5LKuooLF6XIVy',
'secret' =>'ENKzNNj51p6OJvCbnN6jImgGpCF0t22Sv85kCVcmBj1ywOG_HFC85hk6B8G_55I-TzW3dOekxNhC1afk',

/**
* SDK configuration 
*/
'settings' => array(
	/**
	* Available option 'sandbox' or 'live'
	*/
	'mode' => 'sandbox',
	/**
	* Specify the max request time in seconds
	*/
	'http.ConnectionTimeOut' => 1000,
	/**
	* Whether want to log to a file
	*/
	'log.LogEnabled' => true,
	/**
	* Specify the file that want to write on
	*/
	'log.FileName' => storage_path() . '/logs/paypal.log',
	/**
	* Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
	*
	* Logging is most verbose in the 'FINE' level and decreases as you
	* proceed towards ERROR
	*/
	'log.LogLevel' => 'FINE'
	),

];
