<?php $this->display('builder/types_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'type_name',
			'form_type',
			'field_type',
			'category',
			'sort',
			'type_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('builder/types_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>