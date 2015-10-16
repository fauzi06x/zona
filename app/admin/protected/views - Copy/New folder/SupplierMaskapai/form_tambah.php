<section class="content-header">
	<h1>
	Supplier Maskapai
	<small>Tambah Maskapai</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?php echo Yii::app()->baseUrl.'/supplierMaskapai'; ?>"><i class="fa fa-plane"></i> Supplier Maskapai</a></li>
		<li class="active"><i class="fa fa-pencil"></i> Tambah Supplier Maskapai</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-pencil"></i> Tambah Supplier Maskapai</h3>
				</div><!-- /.box-header -->
				<?php
					echo CHtml::beginForm(array('supplierMaskapai/tambah'),'post', array('id'=>'form-tambah','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
				<div class="box-body">
					<div class="form-group" id="for_akun_supp_maskapai">
						<?php  echo CHtml::activeLabel($model, 'akun_supp_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'akun_supp_maskapai', array('class'=>'form-control', 'placeholder'=>'Kode Maskapai')); 
								echo CHtml::error($model,'akun_supp_maskapai', array('id'=>'error_akun_supp_maskapai', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group" id="for_nama_maskapai">
						<?php  echo CHtml::activeLabel($model, 'id_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<select id="SupplierMaskapai_nama_maskapai" name="SupplierMaskapai[id_maskapai]" class="form-control">
								<option value=''>Pilih</option>
								<?php
									foreach($maskapai as $key=>$val)
									{
										echo '<option value="'.$val['id_maskapai'].'">'.$val['nama_maskapai'].'</option>';
									}
								?>
							</select>
							<?php echo CHtml::error($model,'id_maskapai', array('id'=>'error_nama_maskapai', 'class'=>'label-error')); ?>
						</div>
					</div>
					<div class="form-group" id="for_url_maskapai">
						<?php  echo CHtml::activeLabel($model, 'url_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'url_maskapai', array('class'=>'form-control', 'placeholder'=>'Url Api')); 
								echo '<br>'.CHtml::error($model,'url_maskapai', array('id'=>'error_url_maskapai', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'ket_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextarea($model,'ket_maskapai', array('cols'=>100,'class'=>'form-control', 'placeholder'=>'Keteterangan'));
							 ?>
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
