<?php
$elements = $this->elementCollections;
$this->widget('ui\bootstrap\widgets\FormBuilder', 
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id, 'continue' => $this->continue)),
		'errors' => $this->errors,
		'values' => $this->data,
		'elementCollections' => $elements,
		'elements' => array(
			'group_name',
			'generator_name',
			'sort',
			'description',
			'generator_id',
			'http_referer' => array(
				'type' => 'hidden',
				'value' => $this->http_referer
			),
			'button_save' => $elements->uiComponents->getButtonSave(),
			'button_save2close' => $elements->uiComponents->getButtonSaveClose(),
			'button_save2new' => $elements->uiComponents->getButtonSaveNew(),
			'button_cancel' => $elements->uiComponents->getButtonCancel()
		)
	)
);
?>