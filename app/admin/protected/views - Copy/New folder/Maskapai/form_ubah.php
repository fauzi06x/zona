<section class="content-header">
	<h1>
	Maskapai
	<small>Ubah Maskapai</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?php echo Yii::app()->baseUrl.'/maskapai'; ?>"><i class="fa fa-plane"></i> Maskapai</a></li>
		<li class="active"><i class="fa fa-edit"></i> Ubah Maskapai</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-edit"></i> Ubah Maskapai</h3>
				</div><!-- /.box-header -->
				<?php
					echo CHtml::beginForm(array('maskapai/ubah/'.$maskapai['id_maskapai']),'post', array('id'=>'form-tambah','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
				<div class="box-body">
					<div class="box-body">
					<div class="form-group" id="for_kode_maskapai">
						<?php  echo CHtml::activeLabel($model, 'kode_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-2">
							<?php 
								echo CHtml::activetextField($model,'kode_maskapai', array('value'=>$maskapai['kode_maskapai'], 'class'=>'form-control', 'placeholder'=>'Kode Maskapai')); 
								echo CHtml::error($model,'kode_maskapai', array('id'=>'error_kode_maskapai', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group" id="for_nama_maskapai">
						<?php  echo CHtml::activeLabel($model, 'nama_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'nama_maskapai', array('value'=>$maskapai['nama_maskapai'], 'class'=>'form-control', 'placeholder'=>'Nama Maskapai')); 
								echo CHtml::error($model,'nama_maskapai', array('id'=>'error_nama_maskapai', 'class'=>'label-error'));
							 ?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'jenis_maskapai', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<select class="form-control" id="Maskapai_jenis_maskapai" name="Maskapai[jenis_maskapai]">
								<option value="Internasional" <?php echo $maskapai['jenis_maskapai']=='Internasional' ?'selected':''; ?>>Internasional</option>
								<option value="Domestik" <?php echo $maskapai['jenis_maskapai']=='Domestik' ?'"selected"':''; ?>>Domestik</option>
							</select>
						</div>
					</div>
					<div class="form-group" id="for_kode_api">
						<?php  echo CHtml::activeLabel($model, 'kode_api', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'kode_api', array('value'=>$maskapai['kode_api'], 'class'=>'form-control', 'placeholder'=>'Nama Api')); 
								echo '<br>'.CHtml::error($model,'kode_api', array('id'=>'error_kode_api', 'class'=>'label-error')); 
							 ?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'kode_share', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<?php 
								echo CHtml::activetextField($model,'kode_share', array('value'=>$maskapai['kode_share'], 'class'=>'form-control', 'placeholder'=>'Nama Share'));
							 ?>
						</div>
					</div>
					<div class="form-group">
						<?php  echo CHtml::activeLabel($model, 'status', array('class'=>'col-sm-2 control-label'));?>
						<div class="col-sm-4">
							<div class="basic-toggle-button">
                                <input type="checkbox" name="Maskapai[status]" value="1" <?php echo $maskapai['status']==1 ? 'checked':''; ?>/>
                            </div>
						</div>
					</div>
				</div>
				</div>
				<div class="box-footer">
					<div class="col-xs-4 col-xs-push-2">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
					<a class="btn btn-warning pull-right" href="<?php echo Yii::app()->baseUrl;?>/maskapai" ><i class="fa fa-undo"></i> Kembali</a>
				</div>
				<?php echo CHtml::endForm(); ?>
			</div>
		</div>	
	</div>			
</section>


<script>
$(document).ready(function(){

	if ($('#error_nama_maskapai').html())
		$("#for_nama_maskapai").addClass('has-error');
	if ($('#error_kode_maskapai').html())
		$("#for_kode_maskapai").addClass('has-error');
	if ($('#error_kode_api').html())
		$("#for_kode_api").addClass('has-error');

	$('#Maskapai_nama_maskapai').keyup(function(){
		$("#for_nama_maskapai").removeClass('has-error');
		$("#error_nama_maskapai").remove();
	});
	$('#Maskapai_kode_maskapai').keyup(function(){
		$("#for_kode_maskapai").removeClass('has-error');
		$("#error_kode_maskapai").remove();
	});
	$('#Maskapai_kode_api').keyup(function(){
		$("#for_kode_api").removeClass('has-error');
		$("#error_kode_api").remove();
	});

	$('.basic-toggle-button').toggleButtons({
		width: 200,
		label: {
			enabled: "Aktif",
			disabled: "Tidak Aktif"
		}
    });
	
	 $('#toggle-two').bootstrapToggle({
      on: 'Aktif',
      off: 'Tidak Aktif'
    });	
	
});
</script>