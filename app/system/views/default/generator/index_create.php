<?php
$this->widget('koala\widgets\FormBuilder', 
	array(
		'name' => 'create',
		'errors' => $this->errors,
		'elementCollections' => $this->helper,
		'elements' => array(
			'generator_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'index_row_btns',
			'description',
			'trash',
			'act_index_name',
			'act_view_name',
			'act_create_name',
			'act_modify_name',
			'act_remove_name',
			'creator_id',
			'dt_created',
			'modifier_id',
			'dt_modified',
			'button_save' => array(
				'type' => 'button',
				'label' => '保存',
				'glyphicon' => 'save',
				'class' => 'btn btn-primary',
				'onclick' => "return Core.formSubmit('save', 'create');"
			),
			'button_save2close' => array(
				'type' => 'button',
				'label' => '保存并关闭',
				'glyphicon' => 'ok-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit('save2close', 'create');"
			),
			'button_save2new' => array(
				'type' => 'button',
				'label' => '保存并新建',
				'glyphicon' => 'plus-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit('save2new', 'create');"
			),
			'button_cancel' => array(
				'type' => 'button',
				'label' => '取消',
				'glyphicon' => 'remove-sign',
				'class' => 'btn btn-danger',
				'onclick' => "return Core.href('#');"
			)
		)
	)
);
?>