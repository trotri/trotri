<?php $this->display('builder/validators_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'validator_name',
			'field_name',
			'options',
			'option_category',
			'message',
			'sort',
			'when',
			'validator_id',
			'_operate_',
		),
		// 'checkedToggle' => 'validator_id',
	)
);
?>

<?php $this->display('builder/validators_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>