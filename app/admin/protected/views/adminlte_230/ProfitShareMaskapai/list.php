<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/profitShareMaskapai/hapus/'; ?>' + id;
	return window.location.replace(url);
}
</script>
<?php
Yii::app()->clientScript->registerScript('search', "
	// $('.search-form form').submit(function(){
		// $('#users-grid').yiiGridView('update', {
			// data: $(this).serialize()
		// });
		// return false;
	// });
	$('.search-select').change(function(){
		val = $('.search-select').val();
		name_input = 'ProfitShareMaskapai['+val+']';
		$('.search-input').attr('name', name_input);
		
	});
");
?>
<section class="content-header">
	<h1>
	Profit Share Maskapai
	<small>Semua Profit Share Maskapai</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="active"><i class="fa fa-plane"></i> Semua Profit Share Maskapai</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-plane"></i> Semua Profit Share Maskapai</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<?php if(Yii::app()->user->hasFlash('success')):?>
					<div class="message">
						<div class="alert alert-success">
							<button data-dismiss="alert" class="close"></button>
							<?php echo Yii::app()->user->getFlash('success'); ?>
						</div>
					</div>
					<?php endif;?>
					<a class="btn btn-block btn-primary" href="<?php echo Yii::app()->baseUrl ?>/profitShareMaskapai/tambah"><i class="icon-pencil"></i> Tambah Profit Share Maskapai</a>
					<div class="search-form">
						<?php $this->renderPartial('_cari',array(
							'model'=>$model,
						)); ?>
					</div><!-- search-form -->		
					<div class="clearfix"></div>
					<?php 	
					$arrayDataProvider=new CArrayDataProvider($profitShareMaskapai, array(
						'keyField'=>'id_profit_share_maskapai',
						'pagination'=>array(
							'pageSize'=>10,
							),
					));
					$this->widget('zii.widgets.grid.CGridView', array(
						'id'=>'users-grid',
						'itemsCssClass'=>'table table-hover table-striped table-bordered table-condensed',
						'dataProvider' => $arrayDataProvider,
						
						// 'ajaxUrl'=> Yii::app()->request->getUrl(),
						'columns' => array(
							array(
								'header'=>'No.',
								'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
							),
							array(
								'name' => 'Nama Maskapai',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["nama_maskapai"])'
							),
							array(
								'name' => 'Kelas Maskapai',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["kelas_maskapai"])'
							),
							array(
								'name' => 'Full Share (%)',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["full_share"])'
							),
							array(
								'name' => 'Tipe Share',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["tipe_share"]) > 0 ? "<span class=\'label label-success\'>Profit</span>":"<span class=\'label label-danger\'>Diskon</span>"'
							),
							array(
								'name' => 'Nilai Share (%)',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["nilai_share"])'
							),
							array(
								'name' => 'Action',
								'type' => 'raw',
								'value' => '"<a title=\'Ubah Profit Share Maskapai\' href=\'".Yii::app()->baseUrl."/profitShareMaskapai/ubah/".$data[\'id_profit_share_maskapai\']."\' ><i class=\'fa fa-edit\'></i> Ubah</a> | 
								<a title=\'Hapus Hpp Maskapai\' href=\'javascript:del(".$data[\'id_profit_share_maskapai\'].");\' onclick=\'return confirm(\"Anda yakin ingin hapus data ini?\");\' ><i class=\'fa fa-remove \'></i> Hapus</a>"'
							 ),
						),
					)); 
					?>
				</div>
			</div>
		</div>	
	</div>			
</section>
				
