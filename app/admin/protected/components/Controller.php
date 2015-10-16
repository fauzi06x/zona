<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	// public $layout=
	// public $layout='//layouts/container';
	
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function getViewPath()
	{
		$getData 		= Yii::app()->ordercomp->tampilDataPengaturan('sibisnis');
		$data 			= CJSON::decode($getData);
		extract($data);
		$template 		= Yii::app()->_Api->tampilData('template',$template['backend']);
		$controller 	= strtolower(str_replace('Controller','',get_class($this)));
		return dirname(__FILE__).'/../views/'.$template['nama'].'/'.$controller;
	}
	
	public function init()
	{
		$getData = Yii::app()->ordercomp->tampilDataPengaturan('sibisnis');
		$data = CJSON::decode($getData);
		extract($data);

		$template = Yii::app()->_Api->tampilData('template',$template['backend']);
		
		if(Yii::app()->user->isGuest){
			Yii::app()->theme = 'adminlte_230';
			$this->layout='//';
		}else{
			Yii::app()->theme = $template['nama'];
			$this->layout='//'.$template['nama'].'/layouts/main';
		}
		
		
	   parent::init();
	}
	
	
	
}