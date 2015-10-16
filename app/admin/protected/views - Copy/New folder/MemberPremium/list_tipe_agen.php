<?php
Yii::app()->clientScript->registerScript('search', "
	// $('.search-button').click(function(){
		// $('.search-form').toggle();
		// return false;
	// });
	// $('.search-form form').submit(function(){
		// $('#users-grid').yiiGridView('update', {
			// data: $(this).serialize()
		// });
		// return false;
	// });
	$('.search-select').change(function(){
		val = $('.search-select').val();
		name_input = 'MemberPremium['+val+']';
		$('.search-input').attr('name', name_input);
		
	});
");
?>
<section class="content-header">
	<h1>
	Jenis Tipe
	<small>Semua Jenis Tipe dari <?php echo $memberPremium['nama_lengkap']; ?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li><a href="<?php echo Yii::app()->baseUrl.'/memberPremium'; ?>"><i class="fa fa-users"></i>Member Premium</a></li>
		<li class="active">Semua Jenis Tipe dari <?php echo $memberPremium['nama_lengkap']; ?></li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Jenis Tipe</h3>
				</div><!-- /.box-header -->
				<div class="box-body">	
					<div class="clearfix"></div>
					<?php 	
					$arrayDataProvider=new CArrayDataProvider($tipeAgen, array(
						'keyField'=>'id_tipe_agen',
						'pagination'=>array(
							'pageSize'=>5,
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
								'name' => 'Nama Tipe',
								'type' => 'raw',
								'value' => 'CHtml::encode($data["nama_tipe"])'
							),
							array(
								'name' => 'Action',
								'type' => 'raw',
								'value' => '"<a class=\'\' title=\'Lihat Member Agen\' href=\'".Yii::app()->baseUrl."/MemberAgen/view/".$data[\'id_tipe_agen\']."\' ><i class=\'fa fa-fw fa-eye\'></i> Member Agen</a>"'
							),
						),
					)); 
					?>
				</div>
			</div>
		</div>	
	</div>			
</section>
				
