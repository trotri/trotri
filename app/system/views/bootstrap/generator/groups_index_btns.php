<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', 'groups', 'generator', array('generator_id' => $this->generator_id)); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_GENERATOR_GENERATOR_FIELD_GROUPS_CREATE; ?>
  </button>
</form>
