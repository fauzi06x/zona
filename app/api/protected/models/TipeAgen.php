<?php

/**
 * This is the model class for table "tipe_agen".
 *
 * The followings are the available columns in table 'tipe_agen':
 * @property integer $id_tipe_agen
 * @property integer $id_member_premium
 * @property string $nama_tipe
 *
 * The followings are the available model relations:
 * @property MemberPremium $idMemberPremium
 * @property MemberAgen[] $memberAgens
 */
class TipeAgen extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tipe_agen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_member_premium', 'numerical', 'integerOnly'=>true),
			array('nama_tipe', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_tipe_agen, id_member_premium, nama_tipe', 'safe', 'on'=>'search'),
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
			'idMemberPremium' => array(self::BELONGS_TO, 'MemberPremium', 'id_member_premium'),
			'memberAgens' => array(self::HAS_MANY, 'MemberAgen', 'id_tipe_agen'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_tipe_agen' => 'Id Tipe Agen',
			'id_member_premium' => 'Id Member Premium',
			'nama_tipe' => 'Nama Tipe',
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

		$criteria->compare('id_tipe_agen',$this->id_tipe_agen);
		$criteria->compare('id_member_premium',$this->id_member_premium);
		$criteria->compare('nama_tipe',$this->nama_tipe,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TipeAgen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
