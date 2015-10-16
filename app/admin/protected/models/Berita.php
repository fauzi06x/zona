<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Berita extends CFormModel
{
	public $judul;
	public $isi;
	public $gambar;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('judul', 'required'),
			// array('status', 'numerical', 'integerOnly'=>true),
			array('judul, gambar', 'length', 'max'=>255),

			array('isi, waktu_tambah, waktu_ubah', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_halaman, judul, isi, gambar, url, status, waktu_tambah, waktu_ubah', 'safe', 'on'=>'search'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id_halaman' => 'Id Halaman',
			'judul' => 'Judul',
			'isi' => 'Isi',
			'gambar' => 'Gambar',
			'url' => 'Url',
			'status' => 'Status',
			'waktu_tambah' => 'Waktu Tambah',
			'waktu_ubah' => 'Waktu Ubah',
		);
	}

	
	public function listData($model = null, $select = null, $with = null, $condition = null, $order = null)
	{
		
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
	
	public function tambahData($model = null, $params = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : ".$model;

		$curl 	= new Curl;
		$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/create",
		"POST", $params);
		$print= CJSON::decode($result);
		if($print['result'] == 'success')
			return true;
		else 
			return false;
	}
	
	public function tampilData($model = null, $id = null,$params = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : ".$model;
		if(!is_null($id)){
			$curl 	= new Curl;
			$result	= $curl->submit_cURL($dataCurl,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/view/".$id, "POST", $params);
			return CJSON::decode($result);
		}
	}
	
	public function ubahData($model = null, $id = null,$params = null)
	{	
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : ".$model;
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
	
	public function hapusData($model = null, $id = null)
	{
		$dataCurl[]= $this->api_auth('api_user');
		$dataCurl[]= $this->api_auth('api_password');

		$dataCurl[]="X-51815N15-MODEL : ".$model;
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
