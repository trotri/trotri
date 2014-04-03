<?php $this->display('builder/index_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'app_name',
			'mod_name',
			'ctrl_name',
			'cls_name',
			'builder_id',
			'builder_field_groups',
			'builder_fields',
			'_operate_',
		),
		'checkedToggle' => 'builder_id',
	)
);
?>

<?php $this->display('builder/index_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>