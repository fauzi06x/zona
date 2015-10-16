<?php 
$baseUrl = Yii::app()->baseUrl;
?>

<div class="row-fluid">
	<div class="span12">
		<h3 class="page-title">Ubah Maskapai</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-plus"></i>Ubah Maskapai</h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					echo CHtml::beginForm(array('maskapai/update/'.$maskapai['id_maskapai']),'post', array('id'=>'add-form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
					<div class="control-group" id="for_nama_maskapai">
						<?php  echo CHtml::activeLabel($model, 'Nama Maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'nama_maskapai', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Nama Maskapai', 'value'=>$maskapai['nama_maskapai'])); ?>
							<?php echo '<br>'.CHtml::error($model,'nama_maskapai', array('id'=>'error_nama_maskapai', 'class'=>'help-inline help-small no-left-padding error')); ?>
						</div>
					</div>
					<div class="control-group" id="for_jenis_maskapai">
						<?php  echo CHtml::activeLabel($model, 'Jenis Maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<select id="Maskapai_jenis_maskapai" name="Maskapai[jenis_maskapai]" onChange="get_code(this)">
								<option></option>
								
								<option value="Internasional" <?php echo $maskapai['jenis_maskapai']=='Internasional' ?'selected':''; ?>>Internasional</option>
								<option value="Domestik" <?php echo $maskapai['jenis_maskapai']=='Domestik' ?'"selected"':''; ?>>Domestik</option>
							</select>
							<?php echo '<br>'.CHtml::error($model,'jenis_maskapai', array('id'=>'error_jenis_maskapai', 'class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group" id="for_kode_maskapai">
						<?php  echo CHtml::activeLabel($model, 'Kode Maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'kode_maskapai', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Kode Maskapai', 'value'=>$maskapai['kode_maskapai'])); ?>
							<?php echo '<br>'.CHtml::error($model,'kode_maskapai', array('id'=>'error_kode_maskapai', 'class'=>'help-inline help-small no-left-padding error')); ?>
						</div>
					</div>
					<div class="control-group" id="for_kode_api">
						<?php  echo CHtml::activeLabel($model, 'Kode Api', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'kode_api', array('class'=>'m-wrap small placeholder-no-fix', 'placeholder'=>'Kode Api', 'value'=>$maskapai['kode_api'])); ?>
							<?php echo '<br>'.CHtml::error($model,'kode_api', array('id'=>'error_kode_api', 'class'=>'help-inline help-small no-left-padding error')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Kode Share', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'kode_share', array('class'=>'m-wrap small placeholder-no-fix', 'placeholder'=>'Kode Share', 'value'=>$maskapai['kode_share'])); ?>
							<?php echo '<br>'.CHtml::error($model,'kode_share', array('id'=>'error_kode_share', 'class'=>'help-inline help-small no-left-padding error')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Status', array('class'=>'control-label'));?>
						<div class="controls">
							<div class="basic-toggle-button">
                                <input type="checkbox" name="Maskapai[status]" value="1" <?php echo $maskapai['status']==1 ? 'checked':''; ?>/>
								<?php echo '<br>'.CHtml::error($model,'status', array('id'=>'error_status', 'class'=>'help-inline help-small no-left-padding error')); ?>
                            </div>
						</div>
					</div>
					<div class="form-actions">
						<button class="btn green"><i class="icon-save"></i> Save</button>
						<a class="btn red" href="<?php echo Yii::app()->baseUrl;?>/maskapai"><i class="icon-remove-sign"></i> Cancel</a>
					</div>
				<?php echo CHtml::endForm(); //$this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	if ($('#error_nama_maskapai').html())
		$("#for_nama_maskapai").addClass('error');
	if ($('#error_jenis_maskapai').html())
		$("#for_jenis_maskapai").addClass('error');
	if ($('#error_kode_maskapai').html())
		$("#for_kode_maskapai").addClass('error');
	if ($('#error_kode_api').html())
		$("#for_kode_api").addClass('error');
	
	$('#Maskapai_nama_maskapai').keyup(function(){
		$("#for_nama_maskapai").removeClass('error');
		$("#error_nama_maskapai").remove();
	});
	$('#Maskapai_jenis_maskapai').change(function(){
		$("#for_jenis_maskapai").removeClass('error');
		$("#error_jenis_maskapai").remove();
	});
	$('#Maskapai_kode_maskapai').keyup(function(){
		$("#for_kode_maskapai").removeClass('error');
		$("#error_kode_maskapai").remove();
	});
	$('#Maskapai_kode_api').keyup(function(){
		$("#for_kode_api").removeClass('error');
		$("#error_kode_api").remove();
	});
	
});
</script>