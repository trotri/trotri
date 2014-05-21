<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'stbl_name',
			'tbl_name',
			'already_gb',
			'_operate_',
		)
	)
);
?>