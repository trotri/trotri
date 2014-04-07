<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => $this->elements,
		'columns' => array(
			'amca_id',
			'amca_pid',
			'amca_name',
			'amca_pname',
			'prompt',
			'sort',
			'category',
			'_button_history_back_',
		)
	)
);
