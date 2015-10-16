<?php
class _Api extends CApplicationComponent{
	
	public function listData($model = null, $select = null, $with = null, $condition = null, $order = null, $limit = null, $offset = null)
	{
		$dataApi = Yii::app()->globalFunction->dataApi();
		extract($dataApi);

		$header[]	= "X-KEY-API : ".$key;
		$params = array();
		if (!is_null($select) && $select !='')
			$params['select'] = $select;
		if (!is_null($with) && $with !='')
			$params['with'] = $with;
		if (!is_null($condition) && $condition !='')
			$params['condition'] = $condition;
		if (!is_null($order) && $order !='')
			$params['order'] = $order;
		if (!is_null($limit) && $limit !='')
			$params['limit'] = $limit;
		if (!is_null($offset) && $offset !='')
			$params['offset'] = $offset;
		
		$post['params'] 	  = $params;
		$post['api_user']	  = $api_user;
		$post['api_password'] = $api_password;
		$post['signature'] 	  = $signature;
		$post['model'] 	  	  = $model;
		$result	= Yii::app()->_curl->submit_cURL($header,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/list",
		"POST", $post);
		if(is_null(CJSON::decode($result))){
			echo '<h1>Cek, Parameter API Anda!!</h2>';
			exit;		
		}
		return CJSON::decode($result);
	}
	
	public function tambahData($model = null, $params = null)
	{
		$dataApi = Yii::app()->globalFunction->dataApi();
		extract($dataApi);

		$header[]	= "X-KEY-API : ".$key;
		
		$post['params'] 	  = $params;
		$post['api_user']	  = $api_user;
		$post['api_password'] = $api_password;
		$post['signature'] 	  = $signature;
		$post['model'] 	  	  = $model;
		
		$result	= Yii::app()->_curl->submit_cURL($header,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/create",
		"POST", $post);
		$print= CJSON::decode($result);
		if($print['result'] == 'success')
			return true;
		else 
			return false;
	}
	
	public function tampilData($model = null, $id = null,$params = null)
	{
		$dataApi = Yii::app()->globalFunction->dataApi();
		extract($dataApi);
		$header[]	= "X-KEY-API : ".$key;
		$params['id'] = $id;
		$post['params'] 	  = $params;
		$post['api_user']	  = $api_user;
		$post['api_password'] = $api_password;
		$post['signature'] 	  = $signature;
		$post['model'] 	  	  = $model;
	
		$result	= Yii::app()->_curl->submit_cURL($header,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/view/", "POST", $post);

		if(is_null(CJSON::decode($result))){
			echo '<h1>Cek, Parameter API Anda!!</h2>';
			exit;		
		}
		return CJSON::decode($result);
	}
	
	public function ubahData($model = null, $id = null,$params = null)
	{	

		$dataApi = Yii::app()->globalFunction->dataApi();
		extract($dataApi);
		$header[]	= "X-KEY-API : ".$key;
		$params['id'] = $id;
		$post['params'] 	  = $params;
		$post['api_user']	  = $api_user;
		$post['api_password'] = $api_password;
		$post['signature'] 	  = $signature;
		$post['model'] 	  	  = $model;
		
		if(!is_null($id)){
			$result	= Yii::app()->_curl->submit_cURL($header,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/update/", "POST", $post);
			$print= CJSON::decode($result);
			if($print['result'] == 'success')
				return true;
			else 
				return false;
		}
	}
	
	public function hapusData($model = null, $id = null, $params = null)
	{
		
		$dataApi = Yii::app()->globalFunction->dataApi();
		extract($dataApi);
		$header[]	= "X-KEY-API : ".$key;
		$params['id'] = $id;
		$post['params'] 	  = $params;
		$post['api_user']	  = $api_user;
		$post['api_password'] = $api_password;
		$post['signature'] 	  = $signature;
		$post['model'] 	  	  = $model;
		
		if(!is_null($id)){
				$result	= Yii::app()->_curl->submit_cURL($header,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/delete/", "POST", $post);
				$print= CJSON::decode($result);
				if($print['result'] == 'success')
					return true;
				else 
					return false;
		}
	}
	
	
	
}
?>