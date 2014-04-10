<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => $this->elements,
		'columns' => array(
			'group_id',
			'group_pid',
			'group_name',
			'sort',
			'permission',
			'description',
			'_button_history_back_',
		)
	)
);
