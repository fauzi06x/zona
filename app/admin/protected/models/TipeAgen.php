<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class TipeAgen extends CFormModel
{
	public $akun_supp_maskapai;
	public $saldo_supp_maskapai;
	public $url_maskapai;
	public $ket_maskapai;
	public $id_maskapai;
	
	public function rules()
	{
		return array(
			array('akun_supp_maskapai, id_maskapai', 'required'),
			array('saldo_supp_maskapai', 'numerical', 'integerOnly'=>true),
			array('akun_supp_maskapai, url_maskapai', 'length', 'max'=>100),
			array('ket_maskapai', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_supp_maskapai, akun_supp_maskapai, saldo_supp_maskapai, url_maskapai, ket_maskapai, id_maskapai', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id_supp_maskapai' => 'Id Supp Maskapai',
			'akun_supp_maskapai' => 'Nama Akun',
			'saldo_supp_maskapai' => 'Saldo Supp Maskapai',
			'url_maskapai' => 'Url',
			'ket_maskapai' => 'Keterangan',
			'id_maskapai' => 'Nama Maskapai',
		);
	}

	
	public function TipeAgen_list($condition = null, $with = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : TipeAgen";
		$params=array(
			'condition'=>'1 = 1 '.$condition,
			'order'=>'id_tipe_agen ASC',			
		);
		
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST", $params);
		return CJSON::decode($result);
	}
	
	public function TipeAgen_insert($params = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : suppliermaskapai";
		// var_dump($params);
		// die();
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/create",
		"POST", $params);
		
		
		return true;
	}
	
	public function TipeAgen_update($id = null,$params = null)
	{
		
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : suppliermaskapai";
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
	
	public function TipeAgen_delete($id = null)
	{
		
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : suppliermaskapai";
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
