<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', 'validators', 'generator', array('field_id' => $this->field_id)); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->MOD_GENERATOR_GENERATOR_FIELD_VALIDATORS_CREATE; ?>
  </button>
</form>
