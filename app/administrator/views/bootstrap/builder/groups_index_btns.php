<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->MOD_BUILDER_URLS_GROUPS_CREATE,
		'jsfunc' => 'href',
		'url' => $this->getUrlManager()->getUrl('create', '', '', array('builder_id' => $this->builder_id)),
		'glyphicon' => 'create',
		'primary' => true,
	)
);
?>
</form>