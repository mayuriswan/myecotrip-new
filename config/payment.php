<?php

if (in_array(env('APP_ENV'),['local', 'staging'])) {

	return array(
		//SBI Payment Gateway
	    'sbiMerchantId' => '1000205',
	    'sbiKey' => 'rOLcM4P2xf83Eya41Pjxmg==',
	    'actionUrl' => 'https://test.sbiepay.sbi/secure/AggregatorHostedListener',

	);

}else{

	return array(
		//SBI Payment Gateway
	    'sbiMerchantId' => '1000966',
	    //'sbiKey' => 'rJXbIUysuGCjeQ92FGWuSA==',
	    'sbiKey' => 'nZRtvk8TJJ1tJd/O7rU25Q==',
	    'actionUrl' => 'https://www.sbiepay.sbi/secure/AggregatorHostedListener',

	);

}

?>