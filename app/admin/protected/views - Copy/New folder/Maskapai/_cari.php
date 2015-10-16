<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'POST',
	)); ?>
	<div class="col-md-3 pull-right" style="padding-left:0 !important;">
		<div class="input-group margin">
			<input class="form-control search-input" type="text" name="Maskapai[kode_maskapai]">
			<span class="input-group-btn">
			<button class="btn btn-info btn-flat" type="submit"><i class="fa fa-fw fa-search"></i>Cari</button>
			</span>
		</div>	
	</div><!-- /input-group -->
	<div class="input-group margin pull-right" style="margin-right:0 !important;">
		<select class="form-control search-select">
			<option value="kode_maskapai">Kode Maskapai</option>
			<option value="nama_maskapai">Nama Maskapai</option>
			<option value="jenis_maskapai">Jenis Maskapai</option>
			<option value="status">Status</option>
		</select>
	</div>				
	<?php $this->endWidget(); ?>
</div>
