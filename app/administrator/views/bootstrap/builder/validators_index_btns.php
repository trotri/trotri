<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', '', array('field_id' => $this->field_id)); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_BUILDER_BUILDER_FIELD_VALIDATORS_CREATE_LABEL; ?>
  </button>
</form>
