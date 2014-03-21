<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => $this->elements,
		'columns' => array(
			'type_id',
			'type_name',
			'form_type',
			'field_type',
			'category',
			'sort',
			'_button_history_back_'
		)
	)
);
