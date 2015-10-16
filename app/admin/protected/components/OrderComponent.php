<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class OrderComponent extends CApplicationComponent
{
	public function tampilDataPengaturan($domain = ''){
		$params = array(
			'condition'=> "AND t.domain='".$domain."'"
		);
		$getData = Yii::app()->_Api->tampilData('pengaturan',null,$params);
		$data = $getData['isi_pengaturan'];
		return $data;
	}
}