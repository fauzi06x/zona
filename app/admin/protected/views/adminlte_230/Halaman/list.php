<script type="text/javascript">
function del(id) {
	if(id!='')
		url = '<?php echo Yii::app()->baseUrl.'/halaman/hapus/'; ?>' + id;
	return window.location.replace(url);
}
</script>
<?php
Yii::app()->clientScript->registerScript('search', "
	$('.search-select').change(function(){
		val = $('.search-select').val();
		name_input = 'Halaman['+val+']';
		$('.search-input').attr('name', name_input);
		
	});
");
$cs = Yii::app()->getClientScript();
$r = Yii::app()->theme->baseUrl;

$cs->registerCssFile($r.'/assets/plugins/datatables/dataTables.bootstrap.css');
$cs->registerCssFile($r.'/assets/plugins/uniform/css/uniform.default.min.css');
$js[] = $r.'/assets/plugins/datatables/media/js/jquery.dataTables.min.js';
$js[] = $r.'/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js';
$js[] = $r.'/assets/plugins/uniform/jquery.uniform.min.js';

foreach ($js as $file) {
	echo "\n\t\t";
		?><script src="<?php echo $file; ?>"></script><?php
} echo "\n\t";
?>
		
<section class="content-header">
	<h1>
	Halaman
	<small>Semua Halaman</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo Yii::app()->baseUrl.'/dashboard'; ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		<li class="active"><i class="fa fa-map-o"></i> Semua Halaman</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-map-o"></i> Semua Halaman</h3>
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
					<a class="btn btn-block btn-primary" href="<?php echo Yii::app()->baseUrl ?>/halaman/tambah"><i class="icon-pencil"></i> Tambah Halaman</a>
					<div class="search-form">
						<?php $this->renderPartial('_cari',array(
							'model'=>$model,
						)); ?>
					</div><!-- search-form -->		
					<div class="clearfix"></div>
					<table id="table_grid" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="sorting_disabled" width="20" rowspan="1" colspan="1" style="width: 24px;" aria-label=" ">No</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>aksi</th>
                      </tr>
                    </thead>
					<tfoot>
					<tr>
						<th rowspan="1" colspan="1"></th>
						<th rowspan="1" colspan="1">
							<input class="form-control input-sm" type="text" value="" name="input[2]">
						</th>
						<th rowspan="1" colspan="1">
							<select class="form-control input-sm" name="input[3]">
								<option value="" selected></option>
								<option value="0">Tidak Aktif</option>
								<option value="1">Aktif</option>
							</select>
							
						</th>
						<th rowspan="1" colspan="1"></th>
						
					</tr>
					</tfoot>
                    <tbody>
						
					</tbody>
					</table>
				</div>
			</div>
		</div>	
	</div>			
</section>
<script type="text/javascript" src="<?php echo $r.'/assets/plugins/datatables/grid.js'; ?>"></script>
<script type="text/javascript">
var current_url = "<?php echo Yii::app()->baseUrl ?>";
var table = $('#table_grid').DataTable({
    "ajax": current_url + "/halaman/data",
    "columns": <?php echo json_encode($columns); ?>,
    "columnDefs": [ { orderable: false, targets: [0,3] } ],
    "order": [[ 3, "asc" ]]
});
table.columns().every( function() {
    var that = this;
    $( 'input', this.footer() ).on( 'keyup change', function () {
        that.search( this.value ).draw();
    });
    $( 'select', this.footer() ).on( 'change', function () {
        that.search( this.value ).draw();
    });
});

</script>	
