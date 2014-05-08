<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
		'elements' => array(
			'amca_id' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_ID_LABEL,
				'readonly' => true
			),
			'amca_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_LABEL,
				'readonly' => true
			),
			'amca_pname' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'readonly' => true
			),
			'prompt' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_PROMPT_LABEL,
				'readonly' => true
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_SORT_LABEL,
				'readonly' => true
			),
			'category_text' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'readonly' => true
			),
			'_button_history_back_' => views\bootstrap\components\ComponentsBuilder::getButtonHistoryBack(),
		),
		'columns' => array(
			'amca_id',
			'amca_name',
			'amca_pname',
			'prompt',
			'sort',
			'category_text',
			'_button_history_back_',
		)
	)
);
