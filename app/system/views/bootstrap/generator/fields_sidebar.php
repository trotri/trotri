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
	'fields' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_FIELDS_INDEX_LABEL',
		'm' => 'generator', 'c' => 'fields', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_GENERATOR_FIELDS_CREATE_LABEL',
			'm' => 'generator', 'c' => 'fields', 'a' => 'create'
		)
	),
	'groups' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_GROUPS_INDEX_LABEL',
		'm' => 'generator', 'c' => 'groups', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_GENERATOR_GROUPS_CREATE_LABEL',
			'm' => 'generator', 'c' => 'groups', 'a' => 'create'
		)
	),
	'types' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_TYPES_INDEX_LABEL',
		'm' => 'generator', 'c' => 'types', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_GENERATOR_TYPES_CREATE_LABEL',
			'm' => 'generator', 'c' => 'types', 'a' => 'create'
		)
	),
);

if ($this->generator_id > 0) {
	$config['fields']['params']['generator_id'] = $this->generator_id;
	$config['groups']['params']['generator_id'] = $this->generator_id;
	$config['fields']['icon']['params']['generator_id'] = $this->generator_id;
	$config['groups']['icon']['params']['generator_id'] = $this->generator_id;
}

if ($this->controller === 'index') {
	if ($this->action === 'trashindex') {
		$config['index_trashindex']['active'] = true;
	}
	else {
		$config['index_index']['active'] = true;
	}
}
elseif ($this->controller === 'fields') {
	$config['fields']['active'] = true;
}
elseif ($this->controller === 'groups') {
	$config['groups']['active'] = true;
}
elseif ($this->controller === 'types') {
	$config['types']['active'] = true;
}

$this->widget('components\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
