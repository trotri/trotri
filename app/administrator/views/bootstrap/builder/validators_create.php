<?php
$elements = $this->element_collections;
$this->widget('ui\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'create',
		'action' => $this->getUrlManager()->getUrl($this->action),
		'errors' => $this->errors,
		'elementCollections' => $elements,
		'elements' => array(
			'validator_name',
			'field_name',
			'field_id',
			'options',
			'option_category',
			'message',
			'sort',
			'when',
			'button_save' => $elements->uiComponents->getButtonSave(),
			'button_save2close' => $elements->uiComponents->getButtonSaveClose(),
			'button_save2new' => $elements->uiComponents->getButtonSaveNew(),
			'button_cancel' => $elements->uiComponents->getButtonCancel()
		)
	)
);
?>

<script type="text/javascript">
var validators = <?php echo $this->validator_messages; ?>;
</script>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/administrator/js/builder.js'); ?>
