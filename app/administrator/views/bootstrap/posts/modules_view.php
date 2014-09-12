<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'values' => $this->data,
		'elements_object' => $this->elements,
		'elements' => array(
		),
		'columns' => array(
			'module_id',
			'module_name',
			'module_tblname',
			'forbidden',
			'description',
			'_button_history_back_'
		)
	)
);
?>