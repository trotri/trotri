<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->MOD_UCENTER_URLS_USERS_CREATE,
		'jsfunc' => 'href',
		'url' => $this->getUrlManager()->getUrl('create', '', ''),
		'glyphicon' => 'create',
		'primary' => true,
	)
);

$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_FORBIDDEN,
		'jsfunc' => 'batchForbidden',
		'url' => $this->getUrlManager()->getUrl('singlemodify', '', '', array('is_batch' => 1, 'last_index_url' => $this->last_index_url)),
		'glyphicon' => 'forbidden',
		'primary' => false,
	)
);

$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_UNFORBIDDEN,
		'jsfunc' => 'batchForbidden',
		'url' => $this->getUrlManager()->getUrl('singlemodify', '', '', array('is_batch' => 1, 'last_index_url' => $this->last_index_url)),
		'glyphicon' => 'unforbidden',
		'primary' => false,
	)
);

$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_REMOVE,
		'jsfunc' => 'dialogBatchTrash',
		'url' => $this->getUrlManager()->getUrl('trash', '', '', array('is_batch' => 1, 'last_index_url' => $this->last_index_url)),
		'glyphicon' => 'remove',
		'primary' => false,
	)
);
?>
</form>