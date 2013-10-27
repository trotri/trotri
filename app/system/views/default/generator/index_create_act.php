<div class="form-group <?php echo (isset($this->errors['act_index_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">数据列表 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="act_index_name" value="index">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['act_index_name']) ? $this->errors['act_index_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['act_view_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">数据详情 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="act_view_name" value="view">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['act_view_name']) ? $this->errors['act_view_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['act_create_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">新增数据 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="act_create_name" value="create">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['act_create_name']) ? $this->errors['act_create_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['act_modify_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">编辑数据 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="act_modify_name" value="modify">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['act_modify_name']) ? $this->errors['act_modify_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['act_remove_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">删除数据 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="act_remove_name" value="remove">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['act_remove_name']) ? $this->errors['act_remove_name'] : ''); ?></span>
</div><!-- /.form-group -->
