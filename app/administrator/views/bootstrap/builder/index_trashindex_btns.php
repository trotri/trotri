<?php 
$restoreUrl = $this->getUrlManager()->getUrl(
	'batchsinglemodify', '', '',
	array(
		'column_name' => 'trash',
		'value' => 'n',
		'http_return' => $this->http_return
	)
);
?>
<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', ''); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_BUILDER_BUILDERS_CREATE_LABEL; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.batchRestore('<?php echo $restoreUrl; ?>');">
    <span class="glyphicon glyphicon-ok-sign"></span>
    <?php echo $this->MOD_BUILDER_BUILDERS_BATCH_RESTORE_LABEL; ?>
  </button>
</form>
