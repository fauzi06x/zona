<div class="wide form">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>Yii::app()->createUrl($this->route),
		'method'=>'POST',
	)); ?>
	<div class="col-md-3 pull-right" style="padding-left:0 !important;">
		<div class="input-group margin">
			<input class="form-control search-input" type="text" name="SupplierMaskapai[akun_supp_maskapai]">
			<span class="input-group-btn">
			<button class="btn btn-info btn-flat" type="submit"><i class="fa fa-fw fa-search"></i>Cari</button>
			</span>
		</div>	
	</div><!-- /input-group -->
	<div class="input-group margin pull-right" style="margin-right:0 !important;">
		<select class="form-control search-select">
			<option value="akun_supp_maskapai">Nama Akun</option>
			<option value="nama_maskapai">Nama Maskapai</option>
		</select>
	</div>				
	<?php $this->endWidget(); ?>
</div>
