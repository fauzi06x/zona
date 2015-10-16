<?php 
class Curl {	
	public function submit_cURL ($data = ARRAY(), $url = null, $method = null, $params = null) 
	{
		$params = http_build_query($params);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
		if($method=='POST'){	
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);		
		}else if($method=='PUT')
			curl_setopt($ch, CURLOPT_PUT, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		$result = curl_exec($ch);
		curl_close ($ch);

		return $result;
	}	

}