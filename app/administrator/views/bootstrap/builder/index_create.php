<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'tabs' => $this->tabs,
		'errors' => $this->errors,
		'elements' => $this->elements,
		'columns' => array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'cls_name',
			'index_row_btns',
			'description',
			'author_name',
			'author_mail',
			'act_index_name',
			'act_view_name',
			'act_create_name',
			'act_modify_name',
			'act_remove_name',
			'dt_created',
			'dt_modified',
			'_button_save_',
			'_button_save2close_',
			'_button_save2new_',
			'_button_cancel_'
		)
	)
);
