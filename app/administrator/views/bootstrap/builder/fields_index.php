<?php $this->display('builder/fields_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'field_name',
			'builder_name',
			'group_id',
			'type_id',
			'sort',
			'html_label',
			'column_auto_increment',
			'field_id',
			'builder_field_validators',
			'_operate_',
		),
		// 'checkedToggle' => 'field_id',
	)
);
?>

<?php $this->display('builder/fields_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>