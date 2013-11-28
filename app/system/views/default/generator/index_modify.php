<?php
$this->widget('koala\widgets\FormBuilder', 
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id, 'continue' => $this->continue)),
		'errors' => $this->errors,
		'values' => $this->data,
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
			'dt_created',
			'dt_modified',
			'button_save' => array(
				'type' => 'button',
				'label' => $this->CFG_SYSTEM_GLOBAL_SAVE,
				'glyphicon' => 'save',
				'class' => 'btn btn-primary',
				'onclick' => "return Core.formSubmit('save', 'modify');"
			),
			'button_save2close' => array(
				'type' => 'button',
				'label' => $this->CFG_SYSTEM_GLOBAL_SAVE2CLOSE,
				'glyphicon' => 'ok-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit('save_close', 'modify');"
			),
			'button_save2new' => array(
				'type' => 'button',
				'label' => $this->CFG_SYSTEM_GLOBAL_SAVE2NEW,
				'glyphicon' => 'plus-sign',
				'class' => 'btn btn-default',
				'onclick' => "return Core.formSubmit('save_new', 'modify');"
			),
			'button_cancel' => array(
				'type' => 'button',
				'label' => $this->CFG_SYSTEM_GLOBAL_CANCEL,
				'glyphicon' => 'remove-sign',
				'class' => 'btn btn-danger',
				'onclick' => 'return Core.href(\'' . $this->getUrlManager()->getUrl('index') . '\');'
			)
		)
	)
);
?>