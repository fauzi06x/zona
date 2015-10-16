<?php

class MemberAgenController extends Controller
{

	public function actionIndex(){

		$modelMemberAgen	= new memberAgen;
		$modelMemberPremium = new memberPremium;
		$with = 'idTipeAgen';
		
		// function MemberAgen_list($models = null, $select = null, $with = null, $condition = null, $order = null)
		$dataListMemberAgen = $modelMemberAgen->memberAgen_list('MemberAgen', null, $with, null, null);
		
		foreach ($dataListMemberAgen as $key=>$val){
			$dataMemberPremium = $modelMemberPremium->memberPremium_view($val['id_member_premium']);
			$dataListMemberAgen[$key]['upline']=$dataMemberPremium['nama_lengkap'];
			
		}

		if(isset($_POST['MemberAgen'])){
			$dataSearchListMemberAgen = array();
			$MemberAgenPost =$_POST['MemberAgen'];
			if(isset($MemberAgenPost['status'])){
				if(!is_numeric($MemberAgenPost['status']) ){
					if (strpos('aktif', $MemberAgenPost['status']) !== false )
						$MemberAgenPost['status'] = 1;
					else
						$MemberAgenPost['status'] = 0;
				}
			}
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListMemberAgen,$MemberAgenPost);
			foreach($result as $key )
				$dataSearchListMemberAgen[$key]=$dataListMemberAgen[$key];
			$data['memberAgen'] = $dataSearchListMemberAgen;
		}else{
			$data['memberAgen'] = $dataListMemberAgen;
		}
		$data['model'] = $modelMemberAgen;
		$this->render('list',$data);
	}
	
	public function actionView($id){

		$modelMemberAgen	= new memberAgen;
		$modelMemberPremium = new memberPremium;
		$condition = 't.id_tipe_agen ='.$id;
		$with = 'idTipeAgen';
		
		// function MemberAgen_list($models = null, $select = null, $with = null, $condition = null, $order = null)
		$dataListMemberAgen = $modelMemberAgen->memberAgen_list('MemberAgen', null, $with, $condition, null);

		foreach ($dataListMemberAgen as $key=>$val){
			$dataMemberPremium = $modelMemberPremium->memberPremium_view($val['id_member_premium']);
			$dataListMemberAgen[$key]['upline']=$dataMemberPremium['nama_lengkap'];
			
		}
		if(isset($_POST['MemberAgen'])){
			$dataSearchListMemberAgen = array();
			$MemberAgenPost =$_POST['MemberAgen'];
			if(isset($MemberAgenPost['status'])){
				if(!is_numeric($MemberAgenPost['status']) ){
					if (strpos('aktif', $MemberAgenPost['status']) !== false )
						$MemberAgenPost['status'] = 1;
					else
						$MemberAgenPost['status'] = 0;
				}
			}
			$globalFunction = new globalFunction;		
			$result = $globalFunction->multi_array_search($dataListMemberAgen,$MemberAgenPost);
			foreach($result as $key )
				$dataSearchListMemberAgen[$key]=$dataListMemberAgen[$key];
			$data['memberAgen'] = $dataSearchListMemberAgen;
		}else{
			$data['memberAgen'] = $dataListMemberAgen;
		}
		$data['model'] = $modelMemberAgen;
		$this->render('view',$data);
	}
	
	
	
	
	public function actionDelete($id){
		$model = new maskapai;
			if($model->maskapai_delete($id)){
			Yii::app()->user->setFlash('success', "Success! , Data deleted.");
				$this->redirect('../index');
			}	
		$this->render('list');
	}
	
	
}