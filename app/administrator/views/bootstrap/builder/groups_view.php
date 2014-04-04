<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => $this->elements,
		'columns' => array(
			'group_id',
			'group_name',
			'prompt',
			'builder_name',
			'sort',
			'description',
			'_button_history_back_',
		)
	)
);
