<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->MOD_BUILDER_URLS_VALIDATORS_CREATE,
		'jsfunc' => 'href',
		'url' => $this->getUrlManager()->getUrl('create', '', '', array('field_id' => $this->field_id)),
		'glyphicon' => 'create',
		'primary' => true,
	)
);
?>
</form>