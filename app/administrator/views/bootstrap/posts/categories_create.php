<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elements_object' => $this->elements,
		'elements' => array(
			'category_pid' => array(
				'options' => $this->elements->getOptions()
			),
			'module_id' => array(
				'options' => $this->elements->getModuleNames()
			),
		),
		'columns' => array(
			'category_name',
			'category_pid',
			'module_id',
			'meta_title',
			'meta_keywords',
			'meta_description',
			'is_hide',
			'menu_sort',
			'is_jump',
			'jump_url',
			'is_html',
			'html_dir',
			'tpl_home',
			'tpl_list',
			'tpl_view',
			'rule_list',
			'rule_view',
			'_button_save_',
			'_button_saveclose_',
			'_button_savenew_',
			'_button_cancel_'
		)
	)
);
?>