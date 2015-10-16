<?php

/**
 * This is the model class for table "member_agen".
 *
 * The followings are the available columns in table 'member_agen':
 * @property integer $id_member_agen
 * @property string $nama_lengkap
 * @property string $nama_perusahaan
 * @property string $alamat
 * @property string $email
 * @property string $saldo
 * @property string $tmp_saldo
 * @property integer $id_tipe_agen
 *
 * The followings are the available model relations:
 * @property TipeAgen $idTipeAgen
 */
class MemberAgens extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_agen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('saldo, tmp_saldo', 'required'),
			array('id_tipe_agen', 'numerical', 'integerOnly'=>true),
			array('nama_lengkap, nama_perusahaan', 'length', 'max'=>255),
			array('email', 'length', 'max'=>100),
			array('alamat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_member_agen, nama_lengkap, nama_perusahaan, alamat, email, saldo, tmp_saldo, id_tipe_agen', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idTipeAgen' => array(self::BELONGS_TO, 'TipeAgen', 'id_tipe_agen','order'=>'id_member_premium'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_member_agen' => 'Id Member Agen',
			'nama_lengkap' => 'Nama Lengkap',
			'nama_perusahaan' => 'Nama Perusahaan',
			'alamat' => 'Alamat',
			'email' => 'Email',
			'saldo' => 'Saldo',
			'tmp_saldo' => 'Tmp Saldo',
			'id_tipe_agen' => 'Id Tipe Agen',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_member_agen',$this->id_member_agen);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('nama_perusahaan',$this->nama_perusahaan,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('saldo',$this->saldo,true);
		$criteria->compare('tmp_saldo',$this->tmp_saldo,true);
		$criteria->compare('id_tipe_agen',$this->id_tipe_agen);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberAgen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
