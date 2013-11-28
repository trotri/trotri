<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', ''); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_GENERATOR_GENERATORS_CREATE; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.dialogBatchTrash('<?php echo $this->getUrlManager()->getUrl('batchtrash', '', '', array('continue' => $this->getUrlManager()->getRequestUri())); ?>');">
    <span class="glyphicon glyphicon-trash"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_TRASH; ?>
  </button>
</form>
