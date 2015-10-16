<?php
class Menu{
	
	public function menuList($api_user = '',$api_password = ''){
		
		$dataCurl[]="X-51815N15-USERNAME : ".$api_user;
		$dataCurl[]="X-51815N15-PASSWORD : ".$api_password;
		$dataCurl[]="X-51815N15-MODEL : menu";
		$params=array(
			'condition'=>'publish = 1 AND id_company = 1',
			'order'=>'id_menu ASC'
		);
		$curl = new Curl;
		$model=$curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST",$params);
		return CJSON::decode($model);
	}

}