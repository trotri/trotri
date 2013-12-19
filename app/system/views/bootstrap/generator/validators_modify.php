<?php
$elements = $this->elementCollections;
$this->widget('ui\bootstrap\widgets\FormBuilder', 
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'errors' => $this->errors,
		'values' => $this->data,
		'elementCollections' => $elements,
		'elements' => array(
			'validator_name',
			'field_id',
			'field_name',
			'options',
			'option_category',
			'message',
			'sort',
			'when',
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