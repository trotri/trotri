<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => array(
			'amca_id' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_ID_LABEL,
				'readonly' => true
			),
			'amca_name' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_LABEL,
				'readonly' => true
			),
			'amca_pid' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'readonly' => true,
			),
			'amca_pname' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'readonly' => true,
				'value' => $this->service->getAmcaNameById($this->data['amca_pid']),
			),
			'prompt' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_PROMPT_LABEL,
				'readonly' => true
			),
			'sort' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_SORT_LABEL,
				'readonly' => true
			),
			'category' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'readonly' => true
			),
			'category_lang' => array(
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'readonly' => true,
				'value' => $this->service->getCategoryLangByAmcaId($this->data['category']),
			),
			'_button_history_back_' => views\bootstrap\components\ComponentsBuilder::getButtonHistoryBack(),
		),
		'columns' => array(
			'amca_id',
			'amca_name',
			'amca_pid',
			'amca_pname',
			'prompt',
			'sort',
			'category',
			'category_lang',
			'_button_history_back_',
		)
	)
);
