<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11">
    <button type="button" class="btn btn-primary" onclick="return Core.formSubmit('save', 'create');">
      <span class="glyphicon glyphicon-save"></span>
      保存
    </button>
    <button type="button" class="btn btn-default" onclick="return Core.formSubmit('save2index');">
      <span class="glyphicon glyphicon-ok-sign"></span>
      保存并关闭
    </button>
    <button type="button" class="btn btn-default" onclick="return Core.formSubmit('save2create');">
      <span class="glyphicon glyphicon-plus-sign"></span>
      保存并新建
    </button>
    <button type="button" class="btn btn-danger" onclick="return Core.href('<?php echo $this->urls['generator_index']['href']; ?>');">
      <span class="glyphicon glyphicon-remove-sign"></span>
      取消
    </button>
  </div>
</div><!-- /.form-group -->
