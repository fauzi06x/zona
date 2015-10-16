<?php

class SiteController extends Controller
{	
	public $layout='//layouts/login';
	

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->isGuest && Yii::app()->session['var']){
			$this->redirect(array("dashboard/index"));
		}else{
			$this->redirect(array("site/login"));
		}
	}
	public function actionTes()
	{
		echo 'dsa';
		die();
		}
	/**
	 * This is the action to handle external exceptions.
	 */
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

	 
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			// print_r($_POST);
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm'])){
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect('index');	
		}
		
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		unset(Yii::app()->session['var']);
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}