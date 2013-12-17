<?php
$elements = $this->elementCollections;
$this->widget('ui\bootstrap\widgets\FormBuilder', 
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elementCollections' => $elements,
		'elements' => array(
			'type_name',
			'form_type',
			'field_type',
			'category',
			'sort',
			'button_save' => $elements->uiComponents->getButtonSave(),
			'button_save2close' => $elements->uiComponents->getButtonSaveClose(),
			'button_save2new' => $elements->uiComponents->getButtonSaveNew(),
			'button_cancel' => $elements->uiComponents->getButtonCancel()
		)
	)
);
?>
