<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'tabs' => $this->tabs,
		'values' => $this->data,
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