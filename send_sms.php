<?php

	$sender = "Bashar";
	$sms = "Hello, h r u ?";
	$to = "8801718792556";
	$output = sendSMS($sender,$sms,$to);
	print "<br/>";
    print($output);
	function sendSMS($sender,$sms,$to){
		
		$user     = urlencode('hairlife285');
		$password = urlencode('asdf1234');
		$sender   = urlencode($sender);
		$sms      = urlencode($sms);
		$to       = urlencode($to);
		
		$api_params = '?user='.$user.'&password='.$password.'&sender='.$sender.'&SMSText='.$sms.'&GSM='.$to;  
		$smsGatewayUrl = "http://app.planetgroupbd.com/api/sendsms/plain";  
		$smsgatewaydata = $smsGatewayUrl.$api_params;
		$url = $smsgatewaydata;

		$ch = curl_init();                       // initialize CURL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
		//curl_setopt($ch, CURLOPT_INTERFACE, "eaccountbook.com/send_sms.php"); // telling the remote system where to send the data back
		//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"); // pretend you are IE/Mozilla in case the remote server expects it
		curl_setopt($ch, CURLOPT_POST, 1); // setting as a post
		
		$output = curl_exec($ch);
		curl_close($ch);                         // Close CURL

		// Use file get contents when CURL is not installed on server.
		if(!$output){
		   $output =  file_get_contents($smsgatewaydata);  
		}
		return $output;
	}
	
?>