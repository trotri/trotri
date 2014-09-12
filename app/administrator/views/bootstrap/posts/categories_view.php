<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'values' => $this->data,
		'elements_object' => $this->elements,
		'elements' => array(
		),
		'columns' => array(
			'category_id',
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
			'_button_history_back_'
		)
	)
);
?>