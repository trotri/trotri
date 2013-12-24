<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', ''); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_GENERATOR_GENERATORS_CREATE; ?>
  </button>
<?php 
$url = $this->getUrlManager()->getUrl(
	'batchsinglemodify', '', '',
	array(
		'column_name' => 'trash',
		'value' => 'n',
		'http_return' => $this->http_return
	)
);
?>
  <button type="button" class="btn btn-default"
          onclick="return Core.batchRestore('<?php echo $url; ?>');">
    <span class="glyphicon glyphicon-ok-sign"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_RESTORE; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.dialogBatchRemove('<?php echo $this->getUrlManager()->getUrl('batchremove', '', '', array('http_return' => $this->http_return)); ?>');">
    <span class="glyphicon glyphicon-remove-sign"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_REMOVE; ?>
  </button>
</form>
