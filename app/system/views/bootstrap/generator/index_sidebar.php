<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'index_index' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_INDEX_INDEX_LABEL',
		'm' => 'generator', 'c' => 'index', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_GENERATOR_INDEX_CREATE_LABEL',
			'm' => 'generator', 'c' => 'index', 'a' => 'create'
		)
	),
	'index_trashindex' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_INDEX_TRASHINDEX_LABEL',
		'm' => 'generator', 'c' => 'index', 'a' => 'trashindex'
	),
	'types' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_TYPES_INDEX_LABEL',
		'm' => 'generator', 'c' => 'types', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_GENERATOR_TYPES_CREATE_LABEL',
			'm' => 'generator', 'c' => 'types', 'a' => 'create'
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
}
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
