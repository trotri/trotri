<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', ''); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->CFG_SYSTEM_URLS_BUILDER_INDEX_CREATE_LABEL; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.dialogBatchTrash('<?php echo $this->getUrlManager()->getUrl('batchtrash', '', '', array('http_return' => $this->http_return)); ?>');">
    <span class="glyphicon glyphicon-trash"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_TRASH; ?>
  </button>
</form>