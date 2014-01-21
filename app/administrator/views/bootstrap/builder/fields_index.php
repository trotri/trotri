<?php $this->display('builder/fields_index_btns'); ?>

<?php
$elements = $this->element_collections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'data' => $this->data,
		'columns' => array(
			'field_name',
			'builder_id',
			'group_id',
			'type_id',
			'sort',
			'html_label',
			'column_auto_increment',
			'builder_field_validators' => array(
				'name' => 'builder_field_validators',
				'label' => $this->CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELD_VALIDATORS_INDEX_LABEL,
				'callback' => array($elements->uiComponents, 'getBuilderFieldValidatorsLabel')
			),
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		)
	)
);
?>

<?php $this->display('builder/fields_index_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/administrator/js/builder.js'); ?>
