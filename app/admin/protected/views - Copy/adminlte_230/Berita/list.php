<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/berita/hapus/'; ?>' + id;
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
		name_input = 'Berita['+val+']';
		$('.search-input').attr('name', name_input);
		
	});
");
?>
<section class="content-header">
	<h1>
	Berita
	<small>Semua Berita</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="active"><i class="fa fa-newspaper-o"></i> Semua Berita</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-map-o"></i> Semua Berita</h3>
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
					<a class="btn btn-block btn-primary" href="<?php echo Yii::app()->baseUrl ?>/berita/tambah"><i class="icon-pencil"></i> Tambah Berita</a>
					<div class="search-form">
						<?php $this->renderPartial('_cari',array(
							'model'=>$model,
						)); ?>
					</div><!-- search-form -->		
					<div class="clearfix"></div>
					<?php 	
					$arrayDataProvider=new CArrayDataProvider($berita, array(
						'keyField'=>'id_berita',
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
								'name' => 'Judul',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["judul"])'
							),
							array(
								'name' => 'Status',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["status"])== 1 ? "<span class=\'label label-success\'>Aktif</span>":"<span class=\'label label-danger\'>Tidak Aktif</span>"'
							),
							array(
								'name' => 'Action',
								'type' => 'raw',
								'value' => '"<a title=\'Ubah Berita\' href=\'".Yii::app()->baseUrl."/berita/ubah/".$data[\'id_berita\']."\' ><i class=\'fa fa-edit\'></i> Ubah</a> | 
								<a title=\'Hapus Berita\' href=\'javascript:del(".$data[\'id_berita\'].");\' onclick=\'return confirm(\"Anda yakin ingin hapus data ini?\");\' ><i class=\'fa fa-remove \'></i> Hapus</a>"'
							 ),
						),
					)); 
					?>
				</div>
			</div>
		</div>	
	</div>			
</section>
				
