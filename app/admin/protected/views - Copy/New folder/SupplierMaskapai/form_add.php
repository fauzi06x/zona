<?php 
$baseUrl = Yii::app()->baseUrl;
	$maskapai = new Maskapai;
	$maskapaiList= $maskapai->maskapai_list();
	
	foreach($maskapaiList as $p)
		$data[$p['id_maskapai']]=$p['nama_maskapai'];
	ksort($data);

?>
<div class="row-fluid">
	<div class="span12">
		<h3 class="page-title">Tambah supplier Maskapai</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-plus"></i>Tambah supplier Maskapai</h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					echo CHtml::beginForm(array('supplierMaskapai/add'),'post', array('id'=>'add-form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
					
					<div class="control-group" id="for_nama_akun">
						<?php  echo CHtml::activeLabel($model, 'akun_supp_maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'akun_supp_maskapai', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Nama Akun')); ?>
							<?php echo '<br>'.CHtml::error($model,'akun_supp_maskapai', array('id'=>'error_nama_akun','class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'id_maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							
							<select name="SupplierMaskapai[id_maskapai]">
								<option>Pilih</option>
								<?php
									foreach($data as $key=>$val)
									{
										echo '<option value="'.$key.'">'.$val.'</option>';
									}
								?>
							</select>
							<?php echo '<br>'.CHtml::error($model,'id_maskapai', array('class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Url Maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'url_maskapai', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Url Maskapai')); ?>
							
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Ket Maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextarea($model,'ket_maskapai', array('cols'=>100,'class'=>'m-wrap large placeholder-no-fix', 'placeholder'=>'Ket Maskapai')); ?>
							
						</div>
					</div>
					
					<div class="form-actions">
						<button class="btn green"><i class="icon-save"></i> Simpan</button>
						<a class="btn red" href="<?php echo Yii::app()->baseUrl;?>/suppliermaskapai"><i class="icon-remove-sign"></i> Kembali</a>
					</div>
					<?php echo CHtml::endForm(); //$this->endWidget(); ?>
				<!--</form>-->
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){

	if ($('#error_nama_akun').html())
		$("#for_nama_akun").addClass('error');
	if ($('#error_jenis_maskapai').html())
		$("#for_jenis_maskapai").addClass('error');
	if ($('#error_kode_maskapai').html())
		$("#for_kode_maskapai").addClass('error');
	if ($('#error_kode_api').html())
		$("#for_kode_api").addClass('error');
	
	$('#SupplierMaskapai_akun_supp_maskapai').keyup(function(){
		$("#for_nama_akun").removeClass('error');
		$("#error_nama_akun").remove();
	});
	$('#SupplierMaskapai_jenis_maskapai').change(function(){
		$("#for_jenis_maskapai").removeClass('error');
		$("#error_jenis_maskapai").remove();
	});
	$('#SupplierMaskapai_kode_maskapai').keyup(function(){
		$("#for_kode_maskapai").removeClass('error');
		$("#error_kode_maskapai").remove();
	});
	$('#SupplierMaskapai_kode_api').keyup(function(){
		$("#for_kode_api").removeClass('error');
		$("#error_kode_api").remove();
	});
	
});
</script>