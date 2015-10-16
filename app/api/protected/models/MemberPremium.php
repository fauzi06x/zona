<?php

/**
 * This is the model class for table "member_premium".
 *
 * The followings are the available columns in table 'member_premium':
 * @property integer $id_member_premium
 * @property string $nama_lengkap
 * @property string $nama_perusahaan
 * @property string $alamat
 * @property string $email
 * @property string $saldo
 * @property string $tmp_saldo
 * @property integer $status
 */
class MemberPremium extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'member_premium';
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
			array('status', 'numerical', 'integerOnly'=>true),
			array('nama_lengkap, nama_perusahaan, email', 'length', 'max'=>255),
			array('alamat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_member_premium, nama_lengkap, nama_perusahaan, alamat, email, saldo, tmp_saldo, status', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_member_premium' => 'Id Member Premium',
			'nama_lengkap' => 'Nama Lengkap',
			'nama_perusahaan' => 'Nama Perusahaan',
			'alamat' => 'Alamat',
			'email' => 'Email',
			'saldo' => 'Saldo',
			'tmp_saldo' => 'Tmp Saldo',
			'status' => 'Status',
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

		$criteria->compare('id_member_premium',$this->id_member_premium);
		$criteria->compare('nama_lengkap',$this->nama_lengkap,true);
		$criteria->compare('nama_perusahaan',$this->nama_perusahaan,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('saldo',$this->saldo,true);
		$criteria->compare('tmp_saldo',$this->tmp_saldo,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MemberPremium the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
