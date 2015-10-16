<?php

class HppMaskapaiController extends Controller
{
	public $modelApi = 'hppMaskapai';
	public $condition = '';
	public $order = 't.id_hpp_maskapai ASC';
	public $with = 'idMaskapai';
	
	public function actionIndex(){
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		$dataListHppMaskapai = $function->listData($this->modelApi, null, $this->with, $this->condition, $this->order);
		if(isset($_POST['HppMaskapai'])){
			$dataSearchListHppMaskapai = array();
			$HppMaskapaiPost =$_POST['HppMaskapai'];
			if(isset($HppMaskapaiPost['type_share'])){
				if(!is_numeric($HppMaskapaiPost['type_share']) ){
					if (strpos('diskon', $HppMaskapaiPost['type_share']) !== false )
						$HppMaskapaiPost['type_share'] = 0;
					else
						$HppMaskapaiPost['type_share'] = 1;
				}
			}
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListHppMaskapai,$HppMaskapaiPost);
			foreach($result as $key )
				$dataSearchListHppMaskapai[$key]=$dataListHppMaskapai[$key];
			$data['hppMaskapai'] = $dataSearchListHppMaskapai;
		}else{
			$data['hppMaskapai'] = $dataListHppMaskapai;
		}
		$data['model'] = $model;
		$this->render('list',$data);
	}
	
	public function actionTambah(){
		
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		
		if(isset($_POST['HppMaskapai'])){
			$model->attributes=$_POST['HppMaskapai'];
			$data = $_POST['HppMaskapai'];

			if($model->validate() && $function->tambahData($this->modelApi, $data)){
				Yii::app()->user->setFlash('success', "Sukses! , Data berhasil disimpan.");
				$this->redirect('index');
			}
		}
		$data['model'] = $model;
		$data['maskapai'] = $this->getMaskapai();
		$this->render('form_tambah',$data);
	}
	
	public function actionUbah($id){
		$model= $this->getModelClass();
		$function = $this->getVcrudAPI();
		
		if(isset($_POST['HppMaskapai'])){
			$model->attributes=$_POST['HppMaskapai'];
			$data = $model->attributes;
			if($model->validate() && $function->ubahData($this->modelApi, $id, $data)){
				Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}
		}
		$data['model'] = $model;
		$data['hppMaskapai'] = $function->tampilData($this->modelApi, $id);
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
        return new HppMaskapai;
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
				'expression'=>array('HppMaskapaiController','allowOnlyOwner')
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