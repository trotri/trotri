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
	'fields' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELDS_INDEX_LABEL',
		'm' => 'builder', 'c' => 'fields', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELDS_CREATE_LABEL',
			'm' => 'builder', 'c' => 'fields', 'a' => 'create'
		)
	),
	'groups' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELD_GROUPS_INDEX_LABEL',
		'm' => 'builder', 'c' => 'groups', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELD_GROUPS_CREATE_LABEL',
			'm' => 'builder', 'c' => 'groups', 'a' => 'create'
		)
	),
	'types' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_TYPES_INDEX_LABEL',
		'm' => 'builder', 'c' => 'types', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_TYPES_CREATE_LABEL',
			'm' => 'builder', 'c' => 'types', 'a' => 'create'
		)
	),
);

if ($this->builder_id > 0) {
	$config['fields']['params']['builder_id'] = $this->builder_id;
	$config['groups']['params']['builder_id'] = $this->builder_id;
	$config['fields']['icon']['params']['builder_id'] = $this->builder_id;
	$config['groups']['icon']['params']['builder_id'] = $this->builder_id;
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
