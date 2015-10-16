<?php

class ApiController extends Controller
{	
	public function submit_cURL ($data = ARRAY(), $url = null, $method = null, $params = null) 
	{

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
		if($method=='POST'){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}else if($method=='PUT')
		curl_setopt($ch, CURLOPT_PUT, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$result = curl_exec($ch);
		curl_close ($ch);

		return $result;
	}
	public function actionList()
	{
		// {"requestUrl":"http://localhost/~diggindata/yii-blog-rest/index.php/api/posts","requestMethod":"GET","requestBody":"","headers"demo"]}
		$data[]="X-ASCCPE-PASSWORD : demo";
		$data[]="X-ASCCPE-USERNAME : demo";

		$result=$this->submit_cURL($data,"http://localhost/yii-blog-rest/index.php/api/posts","GET");
		print_r($result);
	}
	public function actionCreate()
	{
		// {"requestUrl":"http://localhost/~diggindata/yii-blog-rest/index.php/api/posts","requestMethod":"POST","requestBody":"title=XXX 333&content=Bla&status=1&author_id=1","headers":["Content-type","application/x-www-form-urlencoded ","X_ASCCPE_USERNAME","demo","X_ASCCPE_PASSWORD","demo"]}
		$data[]="X-ASCCPE-PASSWORD : demo";
		$data[]="X-ASCCPE-USERNAME : demo";
		$params = array("name" => "Hagrid", "age" => "36");		
		$params = ($params);  
		$result=$this->submit_cURL($data,"http://localhost/Dropbox/Web/Sibisnis/app/api/api/posts","POST",$params);
		print_r($result);
	}
	public function actionAuth()
	{
		$data[]="X-ASCCPE-PASSWORD : admin";
		$data[]="X-ASCCPE-USERNAME : admin";		
		$result=$this->submit_cURL($data,"http://localhost/Dropbox/Web/Sibisnis/app/api/account/login","GET");
		// karna Auth sudah dihandle di proses api, kita manipulasi method UserAdminIdentity
		$_identity=new UserAdminIdentity($result,$result);  
		$_identity->authenticate();
		echo Yii::app()->user->username;
		die();
		$this->redirect('../site/index');
		
	}
}