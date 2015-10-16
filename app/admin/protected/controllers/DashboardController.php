<?php

class DashboardController extends Controller
{
	//inside your extended controller
	// public function getViewPath()
	// {
	  // $actionId = Yii::app()->controller->getAction()->getId();
	  // $parentActions = array('parentActionOne', 'parentActionTwo');
	  // if(in_array($actionId, $parentActions)){
		// return dirname(__FILE__).'/../views\adminlte_230\dashboard';
		// return $baseUrl = Yii::app()->baseUrl.'/protected/views/adminlte_230/dashboard';
	  // }
	// }

	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	public function accessRules(){         
		return array(        
			array('allow',
				'actions'=>array('index'),
				// 'users'=>array('*'),
				'expression'=>array('DashboardController','allowOnlyOwner')
			),
			array('deny',
				'users'=>array('*'),
				'deniedCallback' => function() {
					$this->redirect(array('/auth'));                            
				},
			),
		);     
	}
	public function allowOnlyOwner(){
		$privilage = new Privilage;
		$rules = $privilage->roleUser();
		return $rules;
    }
	public function actionIndex(){
		
		$this->render('index');
	}
}