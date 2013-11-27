<?php $this->display('generator/index_index_btns'); ?>

<?php
$this->widget(
	'koala\widgets\TableBuilder',
	array(
		'elementCollections' => $this->helper,
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
				'label' => $this->GBL_LANGUAGE_GENERATOR_GENERATOR_FIELD_GROUPS,
				'callback' => array($this->helper, 'getGeneratorFieldGroupsLabel')
			),
			'generator_field_types' => array(
				'name' => 'generator_field_types',
				'label' => $this->GBL_LANGUAGE_GENERATOR_GENERATOR_FIELD_TYPES,
				'callback' => array($this->helper, 'getGeneratorFieldTypesLabel')
			),
			'generator_fields' => array(
				'name' => 'generator_fields',
				'label' => $this->GBL_LANGUAGE_GENERATOR_GENERATOR_FIELDS,
				'callback' => array($this->helper, 'getGeneratorFieldsLabel')
			),
			'generator_id',
			'operate' => array(
				'label' => $this->GBL_LANGUAGE_OPERATE,
				'callback' => array($this->helper, 'getOperateLabel')
			),
		),
		'checkedToggle' => 'generator_id',
		'data' => $this->data
		// 'dataProvider' => 
	)
);
?>

<?php $this->display('generator/index_index_btns'); ?>

<?php
$this->widget(
	'koala\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
