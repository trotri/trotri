<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'errors' => $this->errors,
		'elements_object' => $this->elements,
		'values' => $this->data,
		'elements' => array(
			'amca_pid' => array(
				'value' => $this->data['amca_pid']
			),
			'amca_pname' => array(
				'value' => $this->elements->srv->getAmcaNameByAmcaId($this->data['amca_pid']),
			),
		),
		'columns' => array(
			'amca_name',
			'amca_pid',
			'amca_pname',
			'prompt',
			'sort',
			'category',
			'_button_save_',
			'_button_saveclose_',
			'_button_savenew_',
			'_button_cancel_'
		)
	)
);
