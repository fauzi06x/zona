<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MemberPremium extends CFormModel
{
	public $nama_maskapai;
	public $jenis_maskapai;
	public $kode_maskapai;
	public $kode_api;
	public $kode_share;
	public $status;	
	public function rules()
	{
		return array(
			array('nama_maskapai, jenis_maskapai, kode_maskapai', 'required'),
			array('kode_api', 'numerical'),
			array('status', 'numerical'),
			array('kode_share', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
		);
	}

	
	public function MemberPremium_list()
	{
		// $dataCurl[]="X-51815N15-USERNAME : ".Yii::app()->user->api_user;
		// $dataCurl[]="X-51815N15-PASSWORD : ".Yii::app()->user->api_password;
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : MemberPremium";
		$params=array(
			'condition'=>'',
			'order'=>'id_member_premium ASC'
		);
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST", $params);
		return CJSON::decode($result);
	}
	
	public function MemberPremium_insert($params = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : maskapai";
		
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/create",
		"POST", $params);
		$print= CJSON::decode($result);
		if($print['result'] == 'success')
			return true;
		else 
			return false;
	}
	
	public function MemberPremium_update($id = null,$params = null)
	{
		
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : MemberPremium";
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
	
	public function MemberPremium_delete($id = null)
	{
		
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : MemberPremium";
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
	
	public function MemberPremium_view($id)
	{
		// $dataCurl[]="X-51815N15-USERNAME : ".Yii::app()->user->api_user;
		// $dataCurl[]="X-51815N15-PASSWORD : ".Yii::app()->user->api_password;
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : MemberPremium";
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/view/".$id, "POST");
		return CJSON::decode($result);
	}
	
	public function api_auth($val){
		if($val == 'api_user')
			return "X-51815N15-USERNAME : ".Yii::app()->user->$val;
		else
			return "X-51815N15-PASSWORD : ".Yii::app()->user->$val;
	}
}
