<?php
$elements = $this->element_collections;
$this->widget('ui\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'errors' => $this->errors,
		'values' => $this->data,
		'elementCollections' => $elements,
		'elements' => array(
			'login_name',
			'password',
			'repassword',
			'user_name',
			'user_mail',
			'user_phone',
			'valid_mail',
			'valid_phone',
			'forbidden',
			'trash',
			'dt_registered',
			'dt_last_login',
			'dt_last_repwd',
			'ip_registered',
			'ip_last_login',
			'ip_last_repwd',
			'login_count',
			'repwd_count',
			'button_save' => $elements->uiComponents->getButtonSave(),
			'button_save2close' => $elements->uiComponents->getButtonSaveClose(),
			'button_save2new' => $elements->uiComponents->getButtonSaveNew(),
			'button_cancel' => $elements->uiComponents->getButtonCancel()
		)
	)
);
