<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->urls['generator_create']['href']; ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->urls['generator_create']['label']; ?>
  </button>
<?php 
$url = $this->getUrlManager()->getUrl(
	'batchsinglemodify', '', '',
	array(
		'column_name' => 'trash',
		'value' => 'n',
		'continue' => $this->getUrlManager()->getRequestUri()
	)
);
?>
  <button type="button" class="btn btn-default"
          onclick="return Core.batchRestore('<?php echo $url; ?>');">
    <span class="glyphicon glyphicon-ok-sign"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_RESTORE; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.dialogBatchRemove('<?php echo $this->getUrlManager()->getUrl('batchremove', '', '', array('continue' => $this->getUrlManager()->getRequestUri())); ?>');">
    <span class="glyphicon glyphicon-remove-sign"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_REMOVE; ?>
  </button>
</form>
