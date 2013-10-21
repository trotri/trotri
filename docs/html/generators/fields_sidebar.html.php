<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
  <div class="list-group">
    <a href="generators_index.html.php" class="list-group-item active">
      生成代码管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建生成代码" onclick="return Core.href('../generators/generators_create.html.php');"></span>
    </a>
    <a href="#" class="list-group-item">生成代码回收站</a>
    <a href="fields_index.html.php" class="list-group-item">
      表单字段管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建表单字段" onclick="return Core.href('../generators/fields_create.html.php');"></span>
    </a>
    <a href="groups_index.html.php" class="list-group-item">
      表单字段组管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建表单字段组" onclick="return Core.href('../generators/groups_create.html.php');"></span>
    </a>
    <a href="types_index.html.php" class="list-group-item">
      表单字段类型管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建表单字段类型" onclick="return Core.href('../generators/types_create.html.php');"></span>
    </a>
  </div><!--/.list-group-->

  <div class="list-group">
    <button type="button" class="btn btn-primary btn-block" onclick="return Core.search('../generators/fields_index.html.php');">
      <span class="glyphicon glyphicon-search"></span>查询
    </button>
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="字段名">
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="ID">
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--生成代码--</option>
      <option>users</option>
      <option>user_groups</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--字段类型--</option>
      <option>单行文本 FormType(text) DbType(VARCHAR)</option>
      <option>多行文本 FormType(textarea) DbType(TEXT)</option>
      <option>密码 FormType(password) DbType(CHAR)</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--表单字段组--</option>
      <option>主要信息</option>
      <option>扩展信息</option>
      <option>系统信息</option>
    </select>
    <hr class="hr-condensed">
    <button type="button" class="btn btn-primary btn-block" onclick="return Core.search('../generators/fields_index.html.php');">
      <span class="glyphicon glyphicon-search"></span>查询
    </button>
  </div><!-- /.list-group -->
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
