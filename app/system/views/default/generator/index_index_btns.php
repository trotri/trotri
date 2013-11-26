<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->urls['generator_create']['href']; ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->urls['generator_create']['label']; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.dialogBatchTrash('<?php echo $this->getUrlManager()->getUrl('batchtrash', '', '', array('continue' => $this->getUrlManager()->getRequestUri())); ?>');">
    <span class="glyphicon glyphicon-trash"></span>
    <?php echo $this->GBL_LANGUAGE_BATCH_TRASH; ?>
  </button>
</form>
