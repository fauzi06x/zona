<?php

class SupplierMaskapaiController extends Controller
{
	public $modelApi = 'supplierMaskapai';
	public $condition = '';
	public $order = 't.id_maskapai ASC';
	public $with = 'idMaskapai';
	
	public function actionIndex(){
		
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		$dataListSupplierMaskapai = $function->listData($this->modelApi, null, $this->with, $this->condition, $this->order);
		if(isset($_POST['SupplierMaskapai'])){
			$dataSearchListSupplierMaskapai = array();
			$SupplierMaskapaiPost =$_POST['SupplierMaskapai'];
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListSupplierMaskapai,$SupplierMaskapaiPost);
			foreach($result as $key )
				$dataSearchListSupplierMaskapai[$key]=$dataListSupplierMaskapai[$key];
			$data['supplierMaskapai'] = $dataSearchListSupplierMaskapai;
		}else{
			$data['supplierMaskapai'] = $dataListSupplierMaskapai;
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
		if(isset($_POST['SupplierMaskapai'])){
			$model->attributes=$_POST['SupplierMaskapai'];
			$data = $model->attributes;
            
			if($model->validate() && $function->tambahData($this->modelApi, $data)){
				Yii::app()->user->setFlash('success', "Sukses! , Data berhasil disimpan.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['maskapai'] = $this->getMaskapai();
		$this->render('form_tambah',$data);
	}
	public function actionUbah($id){
		
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if(isset($_POST['SupplierMaskapai'])){
			
			$model->attributes=$_POST['SupplierMaskapai'];
			$data = $model->attributes;

			if($model->validate() && $function->ubahData($this->modelApi, $id, $data)){
				Yii::app()->user->setFlash('success', "Sukses! , Data berhasil disimpan.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['supplierMaskapai'] = $function->tampilData($this->modelApi, $id);
		$data['maskapai'] = $this->getMaskapai();
		$this->render('form_ubah',$data);
	}
	
	public function actionHapus($id){
		$function = $this->getVcrudAPI();
		if($function->hapusData($this->modelApi, $id)){
		Yii::app()->user->setFlash('success', "Sukses! , Data berhasil dihapus.");
			$this->redirect('../index');
		}	
		$this->render('list');
	}
	
	public function getMaskapai(){
		$function = $this->getVcrudAPI();
		$modelApi = 'maskapai';
		$condition = 'status=1';
		$order = 'nama_maskapai ASC';
		$result = $function->listData($modelApi, null, null, $condition, $order);
		if($result)
			return $result;	
	}
	
	public function getModelClass(){
        return new SupplierMaskapai;
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
				'expression'=>array('SupplierMaskapaiController','allowOnlyOwner')
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