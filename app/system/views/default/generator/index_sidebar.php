<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
  <div class="list-group">
    <a href="<?php echo $this->urls['generator_index']['href']; ?>" class="list-group-item active">
      生成代码管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建生成代码" onclick="return Trotri.href('<?php echo $this->urls['generator_create']['href']; ?>');"></span>
    </a>
    <a href="<?php echo $this->urls['generator_index_trash']['href']; ?>" class="list-group-item">生成代码回收站</a>
  </div><!--/.list-group-->
<?php
$helper = $this->helper;
$this->widget('koala\widgets\SearchBuilder', 
	array(
		'action' => $this->urls['generator_index']['href'],
		'elementCollections' => $helper,
		'elements' => array(
			'generator_name',
			'generator_id' => array(
				'type' => 'text',
				'label' => 'ID',
			),
			'tbl_name',
			'tbl_profile' => array(
				'type' => 'select',
				'label' => '是否生成扩展表',
				'options' => $helper::$tblProfiles
			),
			'tbl_engine' => array(
				'type' => 'select',
				'label' => '表引擎',
				'options' => $helper::$tblEngines
			),
			'tbl_charset' => array(
				'type' => 'select',
				'label' => '表编码',
				'options' => $helper::$tblCharsets
			),
			'app_name',
			'button_save' => array(
				'type' => 'submit',
				'label' => '查询',
				'glyphicon' => 'search',
				'class' => 'btn btn-primary btn-block'
			),
		)
	)
);
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
