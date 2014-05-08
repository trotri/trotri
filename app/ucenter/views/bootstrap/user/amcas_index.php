<?php $this->display('user/amcas_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'elements' => array(
			'amca_id' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_ID_LABEL,
			),
			'amca_name' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_NAME_LABEL,
				'callback' => array($this->mod, 'getAmcaNameLink')
			),
			'amca_pid' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PID_LABEL,
			),
			'amca_pname' => array(
				'label' => $this->MOD_USER_USER_AMCAS_AMCA_PNAME_LABEL,
				'callback' => array($this->mod, 'getAmcaPnameTblColumn')
			),
			'prompt' => array(
				'label' => $this->MOD_USER_USER_AMCAS_PROMPT_LABEL,
			),
			'sort' => array(
				'label' => $this->MOD_USER_USER_AMCAS_SORT_LABEL,
			),
			'category' => array(
				'label' => $this->MOD_USER_USER_AMCAS_CATEGORY_LABEL,
				'callback' => array($this->mod, 'getCategoryTblColumn')
			),
		),
		'columns' => array(
			'amca_name',
			'prompt',
			'sort',
			'category',
			'amca_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('user/amcas_index_btns'); ?>