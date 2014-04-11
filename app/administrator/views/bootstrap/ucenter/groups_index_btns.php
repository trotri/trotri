<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->MOD_UCENTER_URLS_GROUPS_CREATE,
		'jsfunc' => 'href',
		'url' => $this->getUrlManager()->getUrl('create', '', ''),
		'glyphicon' => 'create',
		'primary' => true,
	)
);
?>
</form>