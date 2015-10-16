<?php

class AccountController extends Controller
{
    
    public function actionLogin(){
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';	
		if(Yii::app()->globalFunction->_checkSignature($signature,$_POST))
			if(Yii::app()->globalFunction->_checkAuth($api_user,$api_password)){
				extract($params);
				$user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
				if($user===null || !$user->validatePassword($password))
					Yii::app()->globalFunction->_sendResponse(200, CJSON::encode(array('respons'=>'true')));
				return Yii::app()->globalFunction->_sendResponse(200, CJSON::encode($user));
			}
    }
	
	public function actionRegisterMember(){
		$api_user 	  = isset($_POST['api_user'])? $_POST['api_user']:'';
		$api_password = isset($_POST['api_password'])? $_POST['api_password']:'';
		$signature 	  = isset($_POST['signature'])? $_POST['signature']:'';
		$params 	  = isset($_POST['params'])? $_POST['params']:'';	
		if(Yii::app()->globalFunction->_checkSignature($signature,$_POST))
			if(Yii::app()->globalFunction->_checkAuth($api_user,$api_password)){
				extract($params);
				$user=User::model()->find('LOWER(username)=?',array(strtolower($username)));
				if($user===null || !$user->validatePassword($password))
					Yii::app()->globalFunction->_sendResponse(200, CJSON::encode(array('respons'=>'true')));
				return Yii::app()->globalFunction->_sendResponse(200, CJSON::encode($user));
			}
    }


}
?>
