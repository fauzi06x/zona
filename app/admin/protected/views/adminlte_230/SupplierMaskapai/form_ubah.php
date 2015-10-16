<?php 
// $baseUrl = Yii::app()->baseUrl;
// $maskapai = new MaskapaiController;
	// $maskapaiList= $maskapai->maskapai_list();
	
	// foreach($maskapaiList as $p)
		// $data[$p['id_maskapai']]=$p['nama_maskapai'];
	// ksort($data);
?>
<section class="content-header">
	<h1>
	Supplier Maskapai
	<small>Ubah Supplier Maskapai</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?php echo Yii::app()->baseUrl.'/supplierMaskapai'; ?>"><i class="fa fa-plane"></i> Supplier Maskapai</a></li>
		<li class="active"><i class="fa fa-edit"></i> Ubah Supplier Maskapai</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-edit"></i> Ubah Supplier Maskapai</h3>
				</div><!-- /.box-header -->
				<?php
					echo CHtml::beginForm(array('supplierMaskapai/ubah/'.$supplierMaskapai['id_supp_maskapai']),'post', array('id'=>'form-tambah','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
				<div class="box-body">
					<div class="box-body">
					<div class="form-group" id="for_kode_maskapai">
						<?php  echo CHtml::activeLabel($model, 'akun_supp_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'akun_supp_maskapai', array('value'=>$supplierMaskapai['akun_supp_maskapai'], 'class'=>'form-control', 'placeholder'=>'Kode Maskapai')); 
								echo CHtml::error($model,'akun_supp_maskapai', array('id'=>'error_kode_maskapai', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group" id="for_nama_maskapai">
						<?php  echo CHtml::activeLabel($model, 'id_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<select name="SupplierMaskapai[id_maskapai]" class="form-control">
								<option>Pilih</option>
								<?php
									foreach($maskapai as $key=>$val){
										if($val['id_maskapai']==$supplierMaskapai['id_maskapai'])
											$selected = 'selected';
										else
											$selected = '';
										echo '<option value="'.$val['id_maskapai'].'" '.$selected.'>'.$val['nama_maskapai'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group" id="for_kode_api">
						<?php  echo CHtml::activeLabel($model, 'url_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'url_maskapai', array('value'=>$supplierMaskapai['url_maskapai'], 'class'=>'form-control', 'placeholder'=>'Url Api')); 
								echo '<br>'.CHtml::error($model,'url_maskapai', array('id'=>'error_kode_api', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'ket_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextarea($model,'ket_maskapai', array('value'=>$supplierMaskapai['ket_maskapai'], 'cols'=>100,'class'=>'form-control', 'placeholder'=>'Keteterangan'));
							 ?>
						</div>
					</div>
				</div>
				</div>
				<div class="box-footer">
					<div class="col-xs-4 col-xs-push-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
					<a class="btn btn-warning pull-right" href="<?php echo Yii::app()->baseUrl;?>/supplierMaskapai" ><i class="fa fa-undo"></i> Kembali</a>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
		</div>	
	</div>			
</section>


<script>
$(document).ready(function(){

	if ($('#error_akun_supp_maskapai').html())
		$("#for_akun_supp_maskapai").addClass('has-error');
	if ($('#error_nama_maskapai').html())
		$("#for_nama_maskapai").addClass('has-error');
	if ($('#error_url_maskapai').html())
		$("#for_url_maskapai").addClass('has-error');
	
	$('#SupplierMaskapai_akun_supp_maskapai').keyup(function(){
		$("#for_akun_supp_maskapai").removeClass('has-error');
		$("#error_akun_supp_maskapai").remove();
	});
	$('#SupplierMaskapai_nama_maskapai').change(function(){
		$("#for_nama_maskapai").removeClass('has-error');
		$("#error_nama_maskapai").remove();
	});
	$('#SupplierMaskapai_url_maskapai').keyup(function(){
		$("#for_url_maskapai").removeClass('has-error');
		$("#error_url_maskapai").remove();
	});

	
});
</script>