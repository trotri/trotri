<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => $this->elements,
		'columns' => array(
			'validator_id',
			'validator_name',
			'field_name',
			'options',
			'option_category',
			'message',
			'sort',
			'when',
			'_button_history_back_',
		)
	)
);
