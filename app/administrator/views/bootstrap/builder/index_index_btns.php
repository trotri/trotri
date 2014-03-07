<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->MOD_BUILDER_URLS_INDEX_CREATE,
		'jsfunc' => 'href',
		'url' => $this->getUrlManager()->getUrl('create', '', ''),
		'glyphicon' => 'create',
		'primary' => true,
	)
);

$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_TRASH,
		'jsfunc' => 'dialogBatchTrash',
		'url' => $this->getUrlManager()->getUrl('trash', '', '', array('is_batch' => 1, 'last_index_url' => $this->last_index_url)),
		'glyphicon' => 'trash',
	)
);
?>
</form>