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

$this->widget('views\bootstrap\components\bar\SideBar', array('config' => $config));
?>

<?php
if ($this->controller === 'index') {
	$this->widget('views\bootstrap\widgets\SearchBuilder', 
		array(
			'action' => $this->getUrlManager()->getUrl((($this->action == 'trashindex') ? 'trashindex' : 'index'), 'index', 'builder'),
			'elements' => $this->elements,
			'columns' => array(
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

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/builder.js?v=' . $this->version); ?>
