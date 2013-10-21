<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar" role="navigation">
  <div class="list-group">
    <a href="users_index.html.php" class="list-group-item active">
      用户管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建用户" onclick="return Core.href('../users/users_create.html.php');"></span>
    </a>
    <a href="#" class="list-group-item">
      用户组管理
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建用户组"></span>
    </a>
    <a href="#" class="list-group-item">
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新建权限"></span>
      权限管理
    </a>
    <a href="#" class="list-group-item">用户回收站</a>
  </div><!--/.list-group-->

  <div class="list-group">
    <button type="button" class="btn btn-primary btn-block" onclick="return Core.search('../users/users_index.html.php');">
      <span class="glyphicon glyphicon-search"></span>查询
    </button>
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="用户名">
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="ID">
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="邮箱">
    <hr class="hr-condensed">
    <input type="text" name="" class="form-control input-sm" placeholder="登录名">
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--所属用户组--</option>
      <option>管理员</option>
      <option>编辑</option>
      <option>会员</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--验证邮箱--</option>
      <option>已验证</option>
      <option>未验证</option>
    </select>
    <hr class="hr-condensed">
    <select class="form-control input-sm">
      <option>--是否启用--</option>
      <option>启用</option>
      <option>封禁</option>
    </select>
    <hr class="hr-condensed">
    <button type="button" class="btn btn-primary btn-block" onclick="return Core.search('../users/users_index.html.php');">
      <span class="glyphicon glyphicon-search"></span>查询
    </button>
  </div><!-- /.list-group -->
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
