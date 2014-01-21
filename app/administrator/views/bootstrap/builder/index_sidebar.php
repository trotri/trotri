<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'index_index' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDERS_INDEX_LABEL',
		'm' => 'builder', 'c' => 'index', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDERS_CREATE_LABEL',
			'm' => 'builder', 'c' => 'index', 'a' => 'create'
		)
	),
	'index_trashindex' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDERS_TRASHINDEX_LABEL',
		'm' => 'builder', 'c' => 'index', 'a' => 'trashindex'
	),
	'types' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_TYPES_INDEX_LABEL',
		'm' => 'builder', 'c' => 'types', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_TYPES_CREATE_LABEL',
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

<?php
if ($this->controller === 'index') {
	$this->widget('ui\bootstrap\widgets\SearchBuilder', 
		array(
			'action' => $this->getUrlManager()->getUrl((($this->action == 'trashindex') ? 'trashindex' : 'index'), 'index', 'builder'),
			'elementCollections' => $this->element_collections,
			'elements' => array(
				'builder_name',
				'builder_id',
				'tbl_name',
				'tbl_profile',
				'tbl_engine',
				'tbl_charset',
				'app_name'
			)
		)
	);
}
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
