<?php $this->display('builder/groups_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'group_name',
			'builder_name',
			'prompt',
			'sort',
			'description',
			'group_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('builder/groups_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>