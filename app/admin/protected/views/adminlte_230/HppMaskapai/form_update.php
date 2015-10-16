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
		<h3 class="page-title">Ubah Hpp Maskapai</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-plus"></i>Ubah Hpp Maskapai</h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					echo CHtml::beginForm(array('hppmaskapai/update/'.$HppMaskapai['id_hpp_maskapai']),'post', array('id'=>'add-form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
					<div class="control-group" id="for_id_maskapai">
						<?php  echo CHtml::activeLabel($model, 'id_maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<select id="HppMaskapai_id_maskapai" name="HppMaskapai[id_maskapai]">
								<option value="">Pilih</option>
								<?php
									foreach($data as $key=>$val){
										if($key==$HppMaskapai['id_maskapai'])
											$selected = 'selected';
										else
											$selected = '';
										echo '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
									}
								?>
							</select>
							<?php echo '<br>'.CHtml::error($model,'id_maskapai', array('id'=>'error_id_maskapai', 'class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group" id="for_class_maskapai">
						<?php  echo CHtml::activeLabel($model, 'class_maskapai', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'class_maskapai', array('value'=>$HppMaskapai['class_maskapai'], 'class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Class Maskapai')); ?>
							<?php echo '<br>'.CHtml::error($model,'class_maskapai', array('id'=>'error_class_maskapai', 'class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group" id="for_hpp_maskapai">
						<?php  echo CHtml::activeLabel($model, 'hpp_maskapai  (%)', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'hpp_maskapai', array('value'=>$HppMaskapai['hpp_maskapai'], 'class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Hpp Maskapai')); ?>
							<?php echo '<br>'.CHtml::error($model,'hpp_maskapai', array('id'=>'error_hpp_maskapai', 'class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'type_share', array('class'=>'control-label'));?>
						<div class="controls">
							<select name="HppMaskapai[type_share]">
							<?php
							if($key==$HppMaskapai['id_maskapai'])
											$selected = 'selected';
										else
											$selected = '';
							?>
								<option value=0 <?php if($HppMaskapai['type_share']==0)echo'selected';?>>Diskon</option>
								<option value=1 <?php if($HppMaskapai['type_share']==1)echo'selected';?>>Profit</option>
							</select>
						</div>
					</div>
					<div class="control-group" id="for_value_share">
						<?php  echo CHtml::activeLabel($model, 'value_share (%)', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'value_share', array('value'=>$HppMaskapai['value_share'], 'class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Hpp Maskapai')); ?>
							<?php echo '<br>'.CHtml::error($model,'value_share', array('id'=>'error_value_share', 'class'=>'help-inline help-small no-left-padding')); ?>
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

	if ($('#error_id_maskapai').html())
		$("#for_id_maskapai").addClass('error');
	if ($('#error_class_maskapai').html())
		$("#for_class_maskapai").addClass('error');
	if ($('#error_hpp_maskapai').html())
		$("#for_hpp_maskapai").addClass('error');
	if ($('#error_value_share').html())
		$("#for_value_share").addClass('error');
	
	$('#HppMaskapai_id_maskapai').change(function(){
		$("#for_id_maskapai").removeClass('error');
		$("#error_id_maskapai").remove();
	});
	$('#HppMaskapai_class_maskapai').change(function(){
		$("#for_class_maskapai").removeClass('error');
		$("#error_class_maskapai").remove();
	});
	$('#HppMaskapai_hpp_maskapai').keyup(function(){
		$("#for_hpp_maskapai").removeClass('error');
		$("#error_hpp_maskapai").remove();
	});
	$('#HppMaskapai_value_share').keyup(function(){
		$("#for_value_share").removeClass('error');
		$("#error_value_share").remove();
	});
	
});
</script>