<?php

class HomeController extends Controller
{
	public function actionIndex(){
		Yii::app()->_opt->_dataWeb('nama_web');
		Yii::app()->_opt->_id();
		$this->render('index');
	}
}