<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
  <div class="list-group">
    <a href="<?php echo $this->urls['generator_index']['href']; ?>" class="list-group-item active">
      生成代码管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建生成代码" onclick="return Core.href('<?php echo $this->urls['generator_create']['href']; ?>');"></span>
    </a>
    <a href="<?php echo $this->urls['generator_index_trash']['href']; ?>" class="list-group-item">生成代码回收站</a>
  </div><!--/.list-group-->

  <div class="list-group">
    <button type="button" class="btn btn-primary btn-block" onclick="return Core.search('<?php echo $this->urls['generator_index']['href']; ?>');">
      <span class="glyphicon glyphicon-search"></span>查询
    </button>
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="生成代码名">
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="ID">
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="表名">
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--是否生成扩展表--</option>
      <option>是</option>
      <option>否</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--表引擎--</option>
      <option>MyISAM</option>
      <option>InnoDB</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--表编码--</option>
      <option>utf8</option>
      <option>gbk</option>
      <option>gb2312</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--应用名--</option>
    </select>
    <hr class="hr-condensed">
    <button type="button" class="btn btn-primary btn-block" onclick="return Core.search('<?php echo $this->urls['generator_index']['href']; ?>');">
      <span class="glyphicon glyphicon-search"></span>查询
    </button>
  </div><!-- /.list-group -->
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
