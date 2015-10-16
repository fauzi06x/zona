<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

	<?php 
	// if(isset($this->breadcrumbs)):
		// $this->widget('zii.widgets.CBreadcrumbs', array(
            // 'links'=>$this->breadcrumbs,
			// 'homeLink'=>CHtml::link('Dashboard'),
			// 'htmlOptions'=>array('class'=>'breadcrumb')
        // ));
  
	// endif
	?>
    
	<?php echo $content; ?>

<?php $this->endContent(); ?>