<?php
$elementCollections = $this->elementCollections;
$uiComponents = $elementCollections->getUiComponentsInstance();
$this->widget('ui\bootstrap\widgets\FormBuilder', 
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elementCollections' => $elementCollections,
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
			'button_save' => $uiComponents->getButtonSave(),
			'button_save2close' => $uiComponents->getButtonSaveClose(),
			'button_save2new' => $uiComponents->getButtonSaveNew(),
			'button_cancel' => $uiComponents->getButtonCancel()
		)
	)
);
?>