<?php
class _Template extends CApplicationComponent{
	
	public function _init($template = null){
		$init[] = Yii::app()->getClientScript()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/plugins/jQuery/jQuery-2.1.4.min.js');
		$init[] = Yii::app()->getClientScript()->registerScriptFile('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js');
		
		return $init;
	}
	public function js($template = null){
		$data = array();
		
		
		$data['js'] = $js;
		return $data;
	}
	
}
?>