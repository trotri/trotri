<?php $this->display('builder/index_trashindex_btns'); ?>

<?php
$elements = $this->element_collections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'data' => $this->data,
		'columns' => array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'cls_name',
			'builder_field_groups' => array(
				'name' => 'builder_field_groups',
				'label' => '-待开发-',
				'callback' => array($elements->uiComponents, 'getBuilderFieldGroupsLabel')
			),
			'builder_fields' => array(
				'name' => 'builder_fields',
				'label' => '-待开发-',
				'callback' => array($elements->uiComponents, 'getBuilderFieldsLabel')
			),
			'builder_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		),
		'checkedToggle' => 'builder_id',
	)
);
?>

<?php $this->display('builder/index_trashindex_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/administrator/js/builder.js'); ?>
