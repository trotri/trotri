<?php
$this->widget('koala\widgets\FormBuilder', 
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
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
				'label' => $this->GBL_LANGUAGE_SAVE,
				'glyphicon' => 'save',
				'class' => 'btn btn-primary',
				'onclick' => "return Core.formSubmit('save', 'create');"
			),
			'button_save2close' => array(
				'type' => 'button',
				'label' => $this->GBL_LANGUAGE_SAVE2CLOSE,
				'glyphicon' => 'ok-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit('save_close', 'create');"
			),
			'button_save2new' => array(
				'type' => 'button',
				'label' => $this->GBL_LANGUAGE_SAVE2NEW,
				'glyphicon' => 'plus-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit('save_new', 'create');"
			),
			'button_cancel' => array(
				'type' => 'button',
				'label' => $this->GBL_LANGUAGE_CANCEL,
				'glyphicon' => 'remove-sign',
				'class' => 'btn btn-danger',
				'onclick' => 'return Core.href(\'' . $this->getUrlManager()->getUrl('index') . '\');'
			)
		)
	)
);
?>