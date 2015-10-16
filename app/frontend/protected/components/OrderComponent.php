<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class OrderComponent extends CApplicationComponent
{
	public function _dataWeb($kata_kunci = ''){
		
		$domain='sibisnis';
		$data = CJSON::decode($this->tampilDataPengaturan($domain));
		$result = $data[$kata_kunci];
		return $data;
	}
	public function _id(){
		$domain='sibisnis';
		$result = CJSON::decode($this->tampilDataPengaturan($domain, 'id_member_premium'));
		return $result;
	}
	
	public function tampilDataPengaturan($domain = '', $view = 'isi_pengaturan'){
		$params = array(
			'condition'=> "AND t.domain='".$domain."'"
		);
		$getData = Yii::app()->_Api->tampilData('pengaturan',null,$params);
		$result= $getData[$view];
		// $result['_id'] = $getData['id_member_premium'];
		return $result;
	}
}