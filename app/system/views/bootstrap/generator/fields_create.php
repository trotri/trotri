<?php
$elements = $this->elementCollections;
$this->widget('ui\bootstrap\widgets\FormBuilder', 
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elementCollections' => $elements,
		'elements' => array(
			'field_name',
			'column_length',
			'column_auto_increment',
			'column_unsigned',
			'column_comment',
			'generator_name',
			'group_id',
			'generator_id',
			'type_id',
			'sort',
			'html_label',
			'form_prompt',
			'form_required',
			'button_save' => $elements->uiComponents->getButtonSave(),
			'button_save2close' => $elements->uiComponents->getButtonSaveClose(),
			'button_save2new' => $elements->uiComponents->getButtonSaveNew(),
			'button_cancel' => $elements->uiComponents->getButtonCancel()
		)
	)
);
?>