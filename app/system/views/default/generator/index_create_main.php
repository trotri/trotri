<div class="form-group <?php echo (isset($this->errors['generator_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">生成代码名 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="generator_name">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['generator_name']) ? $this->errors['generator_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['tbl_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">表名 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="tbl_name">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['tbl_name']) ? $this->errors['tbl_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['tbl_profile']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">是否生成扩展表</label>
  <div class="col-lg-4">
    <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
      <input type="radio" name="tbl_profile">
    </div>
  </div>
  <span class="control-label"><?php echo (isset($this->errors['tbl_profile']) ? $this->errors['tbl_profile'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['tbl_engine']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">表引擎</label>
  <label class="checkbox-inline">
    <input type="radio" class="icheck" name="tbl_engine" value="MyISAM">
  </label>
  <label class="checkbox-inline">MyISAM</label>
  <label class="checkbox-inline">
    <input type="radio" class="icheck" name="tbl_engine" value="InnoDB" checked>
  </label>
  <label class="checkbox-inline">InnoDB</label>
  <span class="control-label"><?php echo (isset($this->errors['tbl_engine']) ? $this->errors['tbl_engine'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['tbl_charset']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">表编码</label>
  <label class="checkbox-inline">
    <input type="radio" class="icheck" name="tbl_charset" value="utf8" checked>
  </label>
  <label class="checkbox-inline">utf8</label>
  <label class="checkbox-inline">
    <input type="radio" class="icheck" name="tbl_charset" value="gbk">
  </label>
  <label class="checkbox-inline">gbk</label>
  <label class="checkbox-inline">
    <input type="radio" class="icheck" name="tbl_charset" value="gb2312">
  </label>
  <label class="checkbox-inline">gb2312</label>
  <span class="control-label"><?php echo (isset($this->errors['tbl_charset']) ? $this->errors['tbl_charset'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['tbl_comment']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">表描述 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="tbl_comment">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['tbl_comment']) ? $this->errors['tbl_comment'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['app_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">应用名 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="app_name">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['app_name']) ? $this->errors['app_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['mod_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">模块名 *</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="mod_name">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['mod_name']) ? $this->errors['mod_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['ctrl_name']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">控制器名</label>
  <div class="col-lg-4">
    <input type="text" class="form-control input-sm" name="ctrl_name">
  </div>
  <span class="control-label"><?php echo (isset($this->errors['ctrl_name']) ? $this->errors['ctrl_name'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['index_row_btns']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">列表每行操作按钮</label>
  <label class="checkbox-inline">
    <input type="checkbox" class="icheck" name="index_row_btns[]" value="pencil" checked>
  </label>
  <label class="checkbox-inline">编辑</label>
  <label class="checkbox-inline">
    <input type="checkbox" class="icheck" name="index_row_btns[]" value="trash">
  </label>
  <label class="checkbox-inline">放入回收站</label>
  <label class="checkbox-inline">
    <input type="checkbox" class="icheck" name="index_row_btns[]" value="remove">
  </label>
  <label class="checkbox-inline">彻底删除</label>
  <span class="control-label"><?php echo (isset($this->errors['index_row_btns']) ? $this->errors['index_row_btns'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['description']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">描述</label>
  <div class="col-lg-4">
    <textarea class="form-control" rows="5" name="description"></textarea>
  </div>
  <span class="control-label"><?php echo (isset($this->errors['description']) ? $this->errors['description'] : ''); ?></span>
</div><!-- /.form-group -->

<div class="form-group <?php echo (isset($this->errors['trash']) ? 'has-error' : ''); ?>">
  <label class="col-lg-2 control-label">放入回收站</label>
  <div class="col-lg-4">
    <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
      <input type="radio" name="trash" checked>
    </div>
  </div>
  <span class="control-label"><?php echo (isset($this->errors['trash']) ? $this->errors['trash'] : ''); ?></span>
</div><!-- /.form-group -->
