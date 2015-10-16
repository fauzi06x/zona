<?php class UserAdminIdentity extends CUserIdentity{	
	private $_id;
	public function authenticate(){

		$dataApi = $this->getDataAPI();
		extract($dataApi);
		
		$header[]	= "X-KEY-API : ".$key;
		$params		= array(
						'username'=>$this->username,
						'password'=>$this->password,
					);	
						
		$post['params'] 	  = $params;
		$post['api_user']	  = $api_user;
		$post['api_password'] = $api_password;
		$post['signature'] 	  = $signature;
		$result=Yii::app()->_curl->submit_cURL($header,"http://localhost/Dropbox/Web/Sibisnis/app/api/account/login","POST", $post);
		$result = json_decode($result);

		if(isset($result->respons)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;		
		}
		else{	
			$this->_id=$result->id_user;
			$this->username=$result->username;					
			$this->setState('username', $result->username);				
			$this->setState('email', $result->email);
			$this->setState('user_group', $result->id_user_group);
			$this->setState('id_company', $result->id_company);				
			$this->errorCode=self::ERROR_NONE;
		}		
		Yii::app()->session['var'] = $result;
		return $this->errorCode==self::ERROR_NONE;	
	}	
	public function getId()	{		
		return $this->_id;	
	}
	
	public function getDataAPI(){
		$globalFunction = new GlobalFunction();
		$result = $globalFunction->dataApi();
		return $result;
	}
}