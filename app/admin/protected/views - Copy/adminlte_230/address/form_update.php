<?php 
$baseUrl = Yii::app()->baseUrl;
	$addressProv = new Address;
	$addressList= $addressProv->address_list();
	
	foreach($addressList as $p)
		$data[$p['prov']]=$p;
	ksort($data);

	

?>
<div class="row-fluid">
	<div class="span12">
		<h3 class="page-title">Update Address</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-plus"></i>Update Address</h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body form">
				<?php
					echo CHtml::beginForm(array('address/update/'.$address['id']),'post', array('id'=>'add-form','class'=>'form-horizontal','enctype'=>'multipart/form-data'));
				?>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'prov', array('class'=>'control-label'));?>
						<div class="controls">
							
							<select name="Address[prov]" onChange="get_code(this)">
								<option>Pilih</option>
								<?php
									// $provinsi = Provinsi::model()->findAll();
									foreach($data as $key=>$val){
										if($key==$address['prov'])
											$selected="selected";
										else
											$selected="";
										echo '<option value="'.$val['code'].'_'.$key.'" '.$selected.'>'.$key.'</option>';
									}
								?>
							</select>
							<?php echo '<br>'.CHtml::error($model,'prov', array('class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Kab', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'kab', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Kab', 'value'=>$address['kab'])); ?>
							<?php echo '<br>'.CHtml::error($model,'kab', array('class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Kec', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'kec', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Kec', 'value'=>$address['kec'])); ?>
							<?php echo '<br>'.CHtml::error($model,'kec', array('class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					<div class="control-group">
						<?php  echo CHtml::activeLabel($model, 'Code', array('class'=>'control-label'));?>
						<div class="controls">
							<?php echo CHtml::activetextField($model,'code', array('class'=>'m-wrap placeholder-no-fix', 'placeholder'=>'Code', 'value'=>$address['code'], 'readonly'=>true)); ?>
							<?php echo '<br>'.CHtml::error($model,'code', array('class'=>'help-inline help-small no-left-padding')); ?>
						</div>
					</div>
					
					<div class="form-actions">
						<button class="btn green"><i class="icon-save"></i> Save</button>
						<a class="btn red" href="<?php echo Yii::app()->baseUrl;?>/address"><i class="icon-remove-sign"></i> Cancel</a>
					</div>
				<?php echo CHtml::endForm(); //$this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>