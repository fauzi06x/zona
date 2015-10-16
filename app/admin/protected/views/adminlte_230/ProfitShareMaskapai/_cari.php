<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'POST',
	)); ?>
	<div class="col-md-3 pull-right" style="padding-left:0 !important;">
		<div class="input-group margin">
			<input class="form-control search-input" type="text" name="HppMaskapai[nama_maskapai]">
			<span class="input-group-btn">
			<button class="btn btn-info btn-flat" type="submit"><i class="fa fa-fw fa-search"></i>Cari</button>
			</span>
		</div>	
	</div><!-- /input-group -->
	<div class="input-group margin pull-right" style="margin-right:0 !important;">
		<select class="form-control search-select">
			<option value="nama_maskapai">Nama Maskapai</option>
			<option value="kelas_maskapai">Kelas Maskapai</option>
			<option value="full_share">Full Share</option>
			<option value="tipe_share">Tipe Share</option>
			<option value="nilai_share">Nilai Share</option>
		</select>
	</div>				
	<?php $this->endWidget(); ?>
</div>
