<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php $this->widget('components\SideBar', array('name' => 'generator_index')); ?>
<?php
$this->widget('ui\bootstrap\widgets\SearchBuilder', 
	array(
		'action' => $this->getUrlManager()->getUrl((($this->action == 'trashindex') ? 'trashindex' : 'index'), 'index', 'generator'),
		'elementCollections' => $this->elementCollections,
		'elements' => array(
			'generator_name',
			'generator_id',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'app_name'
		)
	)
);
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
