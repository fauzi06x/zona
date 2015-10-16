<?php
class {
	public function addressList($api_user = '',$api_password = ''){
		
		$dataCurl[]="X-51815N15-USERNAME : ".$api_user;
		$dataCurl[]="X-51815N15-PASSWORD : ".$api_password;
		$dataCurl[]="X-51815N15-MODEL : address";
		$params=array(
			'condition'=>'1 = 1',
			'order'=>'id ASC',
			// 'group'=>'prov'
		);
		$curl = new Curl;
		$model=$curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST",$params);

		return CJSON::decode($model);
	}

}