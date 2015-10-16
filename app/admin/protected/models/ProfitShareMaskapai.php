<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ProfitShareMaskapai extends CFormModel
{
	public $id_maskapai;
	public $kelas_maskapai;
	public $full_share;
	public $nilai_share;
	public $tipe_share;
	public function rules()
	{
		return array(
			array('id_maskapai, kelas_maskapai', 'required'),
			array('full_share, nilai_share, tipe_share', 'numerical'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id_profit_share_maskapai' => 'Id Profit Share Maskapai',
			'kelas_maskapai' => 'Kelas Maskapai',
			'full_share' => 'Full Share',
			'nilai_share' => 'Nilai Share',
			'type_share' => 'Tipe Share',
			'id_maskapai' => 'Nama Maskapai',
		);
	}
}
