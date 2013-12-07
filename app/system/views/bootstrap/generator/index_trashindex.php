<?php $this->display('generator/index_trashindex_btns'); ?>

<?php
$elements = $this->elementCollections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'columns' => array(
			'generator_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'generator_field_groups' => array(
				'name' => 'generator_field_groups',
				'label' => $this->MOD_GENERATOR_GENERATOR_FIELD_GROUPS,
				'callback' => array($elements->uiComponents, 'getGeneratorFieldGroupsLabel')
			),
			'generator_field_types' => array(
				'name' => 'generator_field_types',
				'label' => $this->MOD_GENERATOR_GENERATOR_FIELD_TYPES,
				'callback' => array($elements->uiComponents, 'getGeneratorFieldTypesLabel')
			),
			'generator_fields' => array(
				'name' => 'generator_fields',
				'label' => $this->MOD_GENERATOR_GENERATOR_FIELDS,
				'callback' => array($elements->uiComponents, 'getGeneratorFieldsLabel')
			),
			'generator_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			)
		),
		'checkedToggle' => 'generator_id',
		'data' => $this->data
	)
);
?>

<?php $this->display('generator/index_trashindex_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
