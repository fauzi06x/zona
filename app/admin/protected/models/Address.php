<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Address extends CFormModel
{
	public $id;	
	public $prov;
	public $kab;
	public $kec;
	public $code;
	
	public function rules()
	{
		return array(
			array('prov, kab, kec, code', 'required'),
			// array('image', 'file', 'types'=>'jpg, gif, png', 'safe' => false),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array();
	}
	
	public function address_search()
	{
		// $dataCurl[]="X-51815N15-USERNAME : ".Yii::app()->user->api_user;
		// $dataCurl[]="X-51815N15-PASSWORD : ".Yii::app()->user->api_password;
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : address";
		$params=array(
			'condition'=>'1=1',
			'order'=>'id ASC'
		);
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/search",
		"POST", $params);

		return CJSON::decode($result);
	}
	
	public function address_list()
	{
		// $dataCurl[]="X-51815N15-USERNAME : ".Yii::app()->user->api_user;
		// $dataCurl[]="X-51815N15-PASSWORD : ".Yii::app()->user->api_password;
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : address";
		$params=array(
			'condition'=>'1=1',
			'order'=>'id ASC'
		);
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST", $params);
		
		return CJSON::decode($result);
	}
	
	public function address_insert($params = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : address";
		
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/create",
		"POST", $params);
		return true;
	}
	
	public function address_update($id = null,$params = null)
	{
		
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : address";
		if(!is_null($id)){
			if(is_null($params)){
				$curl 	= new Curl;
				$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/view/".$id, "POST", $params);
				return CJSON::decode($result);
			}else{
				$curl 	= new Curl;
				$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/update/".$id, "POST", $params);
				$print= CJSON::decode($result);
				if($print['result'] == 'success')
					return true;
				else 
					return false;
			}
		}
	}
	
	public function address_delete($id = null)
	{
		
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : address";
		if(!is_null($id)){
				$curl 	= new Curl;
				$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/delete/".$id, "GET");
				$print= CJSON::decode($result);
				if($print['result'] == 'success')
					return true;
				else 
					return false;
			
		}
	}
	
	public function api_auth($val){
		if($val == 'api_user')
			return "X-51815N15-USERNAME : ".Yii::app()->user->$val;
		else
			return "X-51815N15-PASSWORD : ".Yii::app()->user->$val;
	}
}
