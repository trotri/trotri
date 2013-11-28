<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
  <div class="list-group">
    <a href="<?php echo $this->urls['generator_index']['href']; ?>" class="list-group-item active">
	<?php echo $this->urls['generator_index']['label']; ?>
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $this->urls['generator_create']['label']; ?>" onclick="return Trotri.href('<?php echo $this->urls['generator_create']['href']; ?>');"></span>
    </a>
    <a href="<?php echo $this->urls['generator_trash_index']['href']; ?>" class="list-group-item"><?php echo $this->urls['generator_trash_index']['label']; ?></a>
  </div><!--/.list-group-->
<?php
$this->widget('koala\widgets\SearchBuilder', 
	array(
		'action' => $this->getUrlManager()->getUrl((($this->action == 'trashindex') ? 'trashindex' : 'index'), 'index', 'generator'),
		'elementCollections' => $this->helper,
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
