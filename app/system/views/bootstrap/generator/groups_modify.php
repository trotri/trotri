<?php
$elementCollections = $this->elementCollections;
$uiComponents = $elementCollections->getUiComponentsInstance();
$this->widget('ui\bootstrap\widgets\FormBuilder', 
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id, 'continue' => $this->continue)),
		'errors' => $this->errors,
		'values' => $this->data,
		'elementCollections' => $elementCollections,
		'elements' => array(
			'group_name',
			'generator_name',
			'sort',
			'description',
			'generator_id',
			'button_save' => $uiComponents->getButtonSave(),
			'button_save2close' => $uiComponents->getButtonSaveClose(),
			'button_save2new' => $uiComponents->getButtonSaveNew(),
			'button_cancel' => $uiComponents->getButtonCancel()
		)
	)
);
?>