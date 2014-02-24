<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', ''); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->CFG_SYSTEM_URLS_UCENTER_USERS_CREATE_LABEL; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Ucenter.batchForbidden('<?php echo $this->getUrlManager()->getUrl('batchsinglemodify', '', '', array('http_return' => $this->http_return)); ?>', 'y');">
    <span class="glyphicon glyphicon-lock"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_FORBIDDEN; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Ucenter.batchForbidden('<?php echo $this->getUrlManager()->getUrl('batchsinglemodify', '', '', array('http_return' => $this->http_return)); ?>', 'n');">
    <span class="glyphicon glyphicon-open"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_UNFORBIDDEN; ?>
  </button>
  <button type="button" class="btn btn-default"
          onclick="return Core.dialogBatchRemove('<?php echo $this->getUrlManager()->getUrl('batchremove', '', '', array('http_return' => $this->http_return)); ?>', 'n');">
  <span class="glyphicon glyphicon-remove-sign"></span>
    <?php echo $this->CFG_SYSTEM_GLOBAL_BATCH_REMOVE; ?>
  </button>
</form>
