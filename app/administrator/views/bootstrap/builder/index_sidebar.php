<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'index_index' => array(
		'label' => 'MOD_BUILDER_URLS_INDEX_INDEX',
		'm' => 'builder', 'c' => 'index', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_BUILDER_URLS_INDEX_CREATE',
			'm' => 'builder', 'c' => 'index', 'a' => 'create'
		)
	),
	'index_trashindex' => array(
		'label' => 'MOD_BUILDER_URLS_INDEX_TRASHINDEX',
		'm' => 'builder', 'c' => 'index', 'a' => 'trashindex'
	),
	'types' => array(
		'label' => 'MOD_BUILDER_URLS_TYPES_INDEX',
		'm' => 'builder', 'c' => 'types', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_BUILDER_URLS_TYPES_CREATE',
			'm' => 'builder', 'c' => 'types', 'a' => 'create'
		)
	)
);

if ($this->controller === 'index') {
	if ($this->action === 'trashindex') {
		$config['index_trashindex']['active'] = true;
	}
	else {
		$config['index_index']['active'] = true;
	}
}
elseif ($this->controller === 'types') {
	$config['types']['active'] = true;
}

$this->widget('components\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
