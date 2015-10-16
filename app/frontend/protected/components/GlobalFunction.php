<?php
class GlobalFunction{
	// buat konstantanya
	public static function  CommonVariable(){
		define("ROLE_ADMINISTRATOR", 1);
		define("ROLE_SUPERUSER", 2);
		define("ROLE_USER", 3);

		/* VARIABEL UNTUK USER ROLE (SCOPE DATA KARYAWAN YANG DAPAT DI VIEW)*/  
		$ARRAY_GROUP_ROLE = array (
		ROLE_ADMINISTRATOR => "ADMINISTRATOR", 
		ROLE_SUPERUSER => "SUPERUSER", 
		ROLE_USER => "USER", 
		
		);
	}
	
	//Fungsi untuk filter array
	public function multi_array_search($array, $search){
		
		$result = array();
		foreach ($array as $key => $value){
			foreach ($search as $k => $v){
				if(!empty($v))
					if (!isset($value[$k]) || strpos(strtolower($value[$k]), strtolower($v)) === false )
						continue 2;	
			}
			$result[] = $key;
		}
		return $result;
	}
	
	//Data API
	public function dataApi(){
		$date = date('dY');
		$dataApi = array();
		$dataApi['key'] = '51815N15';
		$dataApi['api_user'] = 'admin';
		$dataApi['api_password'] = 'admin';
		$dataApi['signature'] = sha1(md5($dataApi["key"].$dataApi["api_user"].$dataApi["api_password"].$date));
		return $dataApi;
	}
}
?>