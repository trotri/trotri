<form class="form-inline">
<?php
$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_RESTORE,
		'jsfunc' => 'batchRestore',
		'url' => $this->getUrlManager()->getUrl('trash', '', '', array('is_batch' => 1, 'is_restore' => 1, 'last_index_url' => $this->last_index_url)),
		'glyphicon' => 'restore',
	)
);

$this->widget(
	'views\bootstrap\widgets\ButtonBuilder',
	array(
		'label' => $this->CFG_SYSTEM_GLOBAL_BATCH_REMOVE,
		'jsfunc' => 'dialogBatchRemove',
		'url' => $this->getUrlManager()->getUrl('remove', '', '', array('is_batch' => 1, 'last_index_url' => $this->last_index_url)),
		'glyphicon' => 'remove',
	)
);
?>
</form>