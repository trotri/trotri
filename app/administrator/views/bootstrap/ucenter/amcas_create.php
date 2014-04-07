<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'tabs' => $this->tabs,
		'errors' => $this->errors,
		'elements' => $this->elements,
		'columns' => array(
			'amca_name',
			'amca_pid',
			'amca_pname',
			'prompt',
			'sort',
			'category',
			'_button_save_',
			'_button_save2close_',
			'_button_save2new_',
			'_button_cancel_',
		)
	)
);
