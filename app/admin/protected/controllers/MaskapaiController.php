<?php

class MaskapaiController extends Controller
{
		
	public $modelApi = 'maskapai';
	public $condition = '';
	public $order = 'id_maskapai ASC';
	
	public function actionIndex(){
		
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		$dataListMaskapai = $function->listData($this->modelApi, null, null, $this->condition, $this->order);
		if(isset($_POST['Maskapai'])){
			$dataSearchListMaskapai = array();
			$MaskapaiPost =$_POST['Maskapai'];
			if(isset($MaskapaiPost['status'])){
				if(!is_numeric($MaskapaiPost['status']) ){
					if (strpos('aktif', $MaskapaiPost['status']) !== false )
						$MaskapaiPost['status'] = 1;
					else
						$MaskapaiPost['status'] = 0;
				}
			}
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListMaskapai,$MaskapaiPost);
			foreach($result as $key )
				$dataSearchListMaskapai[$key]=$dataListMaskapai[$key];
			$data['maskapai'] = $dataSearchListMaskapai;
		}else{
			$data['maskapai'] = $dataListMaskapai;
		}
		
		$data['model'] = $model;
		$this->render('list',$data);

	}
	public function actionTambah(){
		
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Maskapai'])){
			$model->attributes=$_POST['Maskapai'];
			$data = $model->attributes;
			if(!isset($_POST['Maskapai']['status']))
				$data['status']=1;
			if($model->validate() && $function->tambahData($this->modelApi, $data)){
				Yii::app()->user->setFlash('success', "Success! , Data berhasil disimpan.");
				$this->redirect('index');
			}
		}
		$this->render('form_tambah',array('model'=>$model));
	}
	public function actionUbah($id){
		
		$model = $this->getModelClass();
		$function = $this->getVcrudAPI();
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['Maskapai'])){
			$model->attributes=$_POST['Maskapai'];

			$data = $model->attributes;
			if($data['status']=='')
				$data['status']=0;
			if($model->validate() && $function->ubahData($this->modelApi, $id, $data)){
				Yii::app()->user->setFlash('success', "Success! , Data berhasil disimpan.");
				$this->redirect('index');
			}
		}
		$data['model'] = $model;
		$data['maskapai'] = $model->tampilData($this->modelApi, $id);
		$this->render('form_ubah',$data);
	}
	
	public function actionHapus($id){
		$function = $this->getVcrudAPI();
			if($function->hapusData($this->modelApi, $id)){
			Yii::app()->user->setFlash('success', "Sukses! , Data berhasil dihapus.");
				$this->redirect('index');
			}	
		$this->render('list');
	}
   
	public function getModelClass(){
        return new Maskapai;
    }
	
	public function getVcrudAPI(){
        return new VcrudAPI;
    }
	
	public function filters()
	{
		return array(
			'accessControl',
		);
	}
	public function accessRules(){         
		return array(        
			array('allow',
				'actions'=>array('index', 'tambah', 'ubah', 'hapus'),
				// 'users'=>array('*'),
				'expression'=>array('MaskapaiController','allowOnlyOwner')
			),
			array('deny',
				'users'=>array('*'),
			),
		);     

	}
	public function allowOnlyOwner(){
		$privilage = new Privilage;
		$rules = $privilage->roleUser();
		return $rules;
    }
}