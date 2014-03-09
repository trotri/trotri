<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'tabs' => $this->tabs,
		'values' => $this->data,
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
			'act_index_name',
			'act_view_name',
			'act_create_name',
			'act_modify_name',
			'act_remove_name',
			'dt_created',
			'dt_modified',
			'_button_history_back_'
		)
	)
);
