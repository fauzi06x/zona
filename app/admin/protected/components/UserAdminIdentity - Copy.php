<?php class UserAdminIdentity extends CUserIdentity {	
	private $_id;
	public function authenticate(){
		
		$data=json_decode($this->password);
		
		// $user=Users::model()->find('LOWER(username)=?',array(strtolower($data->username)));
		if($data===null)			
			$this->errorCode=self::ERROR_USERNAME_INVALID;	
		
		else {	
			Yii::app()->user->setId($data->id_user);
			Yii::app()->user->setName($data->username);					
			Yii::app()->user->setState('username', $data->username);				
			Yii::app()->user->setState('email', $data->email);
			Yii::app()->user->setState('status_user', "user_cms");			
			// $this->setState('route_admin', "cms");			
			$session=array(
				'id_user' => $data->id_user,
				'username' => $data->username,
				'email' => $data->email,
			);	
			Yii::app()->session['var'] = $session;
			
			return $this->errorCode=self::ERROR_NONE;
		}
		
		return $this->errorCode==self::ERROR_NONE;	
	}	

	public function getId()	{		
		return $this->_id;	
	}

}