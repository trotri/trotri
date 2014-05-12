<?php
use views\bootstrap\components\ComponentsBuilder;

$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'tabs' => $this->tabs,
		'errors' => $this->errors,
		'elements' => array(
			'amca_name' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_LABEL,
				'hint' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_HINT,
				'required' => true,
			),
			'amca_pid' => array(
				'type' => 'hidden',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PID_LABEL,
				'value' => $this->amca_pid
			),
			'amca_pname' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'hint' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_HINT,
				'readonly' => true,
				'value' => $this->srv->getAmcaNameByAmcaId($this->amca_pid),
			),
			'prompt' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_PROMPT_LABEL,
				'hint' => $this->MOD_USER_USER_AMCAS_PROMPT_HINT,
				'required' => true,
			),
			'sort' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_SORT_LABEL,
				'hint' => $this->MOD_USER_USER_AMCAS_SORT_HINT,
				'required' => true,
			),
			'category' => array(
				'type' => 'radio',
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'readonly' => true,
				'options' => $this->enum_category,
				'value' => $this->category,
			),
			'_button_save_' => ComponentsBuilder::getButtonSave(),
			'_button_save2close_' => ComponentsBuilder::getButtonSaveClose(),
			'_button_save2new_' => ComponentsBuilder::getButtonSaveNew(),
			'_button_cancel_' => ComponentsBuilder::getButtonCancel(),
		),
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
			'_button_cancel_'
		)
	)
);
