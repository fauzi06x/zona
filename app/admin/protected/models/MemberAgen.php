<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MemberAgen extends CFormModel
{
	public $nama_lengkap;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('saldo, tmp_saldo', 'required'),
			array('id_tipe_agen', 'numerical', 'integerOnly'=>true),
			array('nama_lengkap, nama_perusahaan', 'length', 'max'=>255),
			array('email', 'length', 'max'=>100),
			array('alamat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_member_agen, nama_lengkap, nama_perusahaan, alamat, email, saldo, tmp_saldo, id_tipe_agen', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id_member_agen' => 'Id Member Agen',
			'nama_lengkap' => 'Nama Lengkap',
			'nama_perusahaan' => 'Nama Perusahaan',
			'alamat' => 'Alamat',
			'email' => 'Email',
			'saldo' => 'Saldo',
			'tmp_saldo' => 'Tmp Saldo',
			'id_tipe_agen' => 'Id Tipe Agen',
		);
	}
	
	public function MemberAgen_search($model = null, $select = null, $with = null, $condition = null, $order = null)
	{
		// $dataCurl[]="X-51815N15-USERNAME : ".Yii::app()->user->api_user;
		// $dataCurl[]="X-51815N15-PASSWORD : ".Yii::app()->user->api_password;
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');
		$dataCurl[]="X-51815N15-MODEL : ".$model;
		
		$params = array();
		
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/search",
		"POST", $params);

		
		return CJSON::decode($result);
	}
	
	public function MemberAgen_list($model = null, $select = null, $with = null, $condition = null, $order = null)
	{
		// $dataCurl[]="X-51815N15-USERNAME : ".Yii::app()->user->api_user;
		// $dataCurl[]="X-51815N15-PASSWORD : ".Yii::app()->user->api_password;
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');
		$dataCurl[]="X-51815N15-MODEL : ".$model;
		
		$params = array();
		if (!is_null($select) && $select !='')
		$params['select'] = $select;
		if (!is_null($with) && $with !='')
		$params['with'] = $with;
		if (!is_null($condition) && $condition !='')
		$params['condition'] = $condition;
		if (!is_null($order) && $order !='')
		$params['order'] = $order;

		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST", $params);
		
		return CJSON::decode($result);
	}
	
	public function MemberPremium_insert($params = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : MemberAgen";
		
		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/create",
		"POST", $params);
		return true;
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
	
	public function api_auth($val){
		if($val == 'api_user')
			return "X-51815N15-USERNAME : ".Yii::app()->user->$val;
		else
			return "X-51815N15-PASSWORD : ".Yii::app()->user->$val;
	}
}
