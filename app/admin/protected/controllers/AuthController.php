<?php

class AuthController extends Controller
{	
	public $layout='//';
	public $model='Users';
	public function getViewPath()
	{
		return dirname(__FILE__).'/../views';
	}
	
	public function actionIndex()
	{
		$model=Yii::app()->globalFunction->getModel($this->model);
		
		// if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		// {
			// if(CActiveForm::validate($model))
			// echo CActiveForm::validate($model);
			// Yii::app()->end();
			
		// }

		if(isset($_POST['Users'])){

			$model->attributes=$_POST['Users'];
			if($model->validate() && $model->login())
				$this->redirect(array("dashboard/"));
		}

		$data=array('model'=>$model);
		$this->render('login',$data);
	}
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionLogout()
	{
		unset(Yii::app()->session['var']);
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	
}