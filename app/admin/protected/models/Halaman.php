<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Halaman extends CFormModel
{
	public $judul;
	public $isi;
	public $gambar;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('judul', 'required'),
			// array('status', 'numerical', 'integerOnly'=>true),
			array('judul, gambar', 'length', 'max'=>255),

			array('isi, waktu_tambah, waktu_ubah', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_halaman, judul, isi, gambar, url, status, waktu_tambah, waktu_ubah', 'safe', 'on'=>'search'),
		);
	}
	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'id_halaman' => 'Id Halaman',
			'judul' => 'Judul',
			'isi' => 'Isi',
			'gambar' => 'Gambar',
			'url' => 'Url',
			'status' => 'Status',
			'waktu_tambah' => 'Waktu Tambah',
			'waktu_ubah' => 'Waktu Ubah',
		);
	}

}
