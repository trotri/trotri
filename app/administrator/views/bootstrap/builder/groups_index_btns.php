<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', '', array('builder_id' => $this->builder_id)); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_BUILDER_BUILDER_FIELD_GROUPS_CREATE_LABEL; ?>
  </button>
</form>
