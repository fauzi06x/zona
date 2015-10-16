<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/address/delete/'; ?>' + id;
	return window.location.replace(url);
}
</script>

<div class="row-fluid">
	<div class="span12">
		<h3 class="Address-title">Address</h3>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="portlet box green">
			<div class="portlet-title">
				<h4><i class="icon-file-alt"></i>All Address</h4>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body">
				<?php if(Yii::app()->user->hasFlash('success')):?>
					<div class="message">
						<div class="alert alert-success">
							<button data-dismiss="alert" class="close"></button>
							<strong>Success!</strong> <?php echo Yii::app()->user->getFlash('success'); ?>
						</div>
					</div>
				<?php endif;?>
				<div class="clearfix">
					<div class="btn-group">
						<a class="btn blue" href="<?php echo Yii::app()->baseUrl ?>/address/add"><i class="icon-pencil"></i> Add Address</a>
					</div>
				</div>
				
				<?php 

				 $arrayDataProvider=new CArrayDataProvider($address, array(
					'keyField'=>'id',
					'pagination'=>array(
						'pageSize'=>5,
						),
				));
				$this->widget('zii.widgets.grid.CGridView', array(
					'id'=>'users-grid',
					'itemsCssClass'=>'table table-striped table-bordered table-hover',
					'dataProvider' => $arrayDataProvider,
					'template'=>'{items}{pager}<br>{summary}',
					'columns' => array(
						array(
							'name' => 'kec',
							'type' => 'raw',
							'value' => 'CHtml::encode($data["kec"])'
						),
						array(
							'name' => 'Kab',
							'type' => 'raw',
							'value' => 'CHtml::encode($data["kab"])'
							
						),
						array(
							'name' => 'Prov',
							'type' => 'raw',
							'value' => 'CHtml::encode($data["prov"])'
							
						),
						array
							(
								'class'=>'CButtonColumn',
								'template'=>'{delete}{update}',
							)
					),
				));
				?>
			</div>
		</div>
	</div>
</div>