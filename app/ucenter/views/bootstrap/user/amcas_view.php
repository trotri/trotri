<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
  <head>
<?php $this->display('header'); ?>
  </head>

  <body>

<!-- NavBar -->
<div class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/trotri/webroot/administrator.php?r=system/site/index">Trotri</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
<li class="dropdown active">
<a class="dropdown-toggle" data-toggle="dropdown" href="/trotri/webroot/administrator.php?r=ucenter/users/index">用户管理 <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="/trotri/webroot/administrator.php?r=ucenter/users/index">用户管理<span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新增用户" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=ucenter/users/create')"></span></a></li>
<li class="divider"></li>
<li><a href="/trotri/webroot/administrator.php?r=ucenter/groups/index">用户组管理<span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新增用户组" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=ucenter/groups/create')"></span></a></li>
<li class="divider"></li>
<li><a href="/trotri/webroot/administrator.php?r=ucenter/amcas/index">用户事件管理</a></li>
</ul>
</li>
<li class="dropdown">
<a class="dropdown-toggle" data-toggle="dropdown" href="/trotri/webroot/administrator.php?r=builder/index/index">生成代码管理 <b class="caret"></b></a>
<ul class="dropdown-menu">
<li><a href="/trotri/webroot/administrator.php?r=builder/index/index">生成代码管理<span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="新增生成代码" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=builder/index/create')"></span></a></li>
<li class="divider"></li>
<li><a href="/trotri/webroot/administrator.php?r=builder/index/trashindex">生成代码回收站</a></li>
<li class="divider"></li>
<li><a href="/trotri/webroot/administrator.php?r=builder/schema/index">数据库表管理</a></li>
</ul>
</li>
<li><a href="/trotri/webroot/administrator.php?r=system/site/about">About</a></li>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">SongHuan <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/trotri/webroot/administrator.php?r=system/tools/cacheclear">清理缓存</a></li>
            <li><a href="#">编辑账号</a></li>
            <li class="divider"></li>
            <li><a href="#">退出登录</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.nav-collapse -->
  </div><!-- /.container -->
</div><!-- /.navbar -->
<!-- /NavBar -->


<div class="container">

  <div class="row row-offcanvas row-offcanvas-right">

<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<div class="list-group"><a class="list-group-item active" href="/trotri/webroot/administrator.php?r=ucenter/users/index">用户管理<span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="用户管理" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=ucenter/users/create')"></span></a><a class="list-group-item" href="/trotri/webroot/administrator.php?r=ucenter/groups/index">用户组管理<span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="用户组管理" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=ucenter/groups/create')"></span></a><a class="list-group-item" href="/trotri/webroot/administrator.php?r=ucenter/amcas/index">用户可访问的事件管理</a></div><!--/.list-group-->
<!-- SearchBuilder -->
<div class="list-group">
<form id="form_id_2" name="" action="/trotri/webroot/administrator.php?r=ucenter/users/index" method="get"><button class="btn btn-primary btn-block" type="button" name="_button_search_"><span class="glyphicon glyphicon-search"></span>查询</button>
<hr class="hr-condensed" /><input class="form-control input-sm" placeholder="登录名" type="text" name="login_name" value="" />
<hr class="hr-condensed" /><select class="form-control input-sm" placeholder="登录方式" name="login_type"><option selected="selected" value="">--登录方式--</option><option value="mail">邮箱</option><option value="name">用户名</option><option value="phone">手机号</option></select>
<hr class="hr-condensed" /><input class="form-control input-sm" placeholder="用户名" type="text" name="user_name" value="" />
<hr class="hr-condensed" /><input class="form-control input-sm" placeholder="用户邮箱" type="text" name="user_mail" value="" />
<hr class="hr-condensed" /><input class="form-control input-sm" placeholder="手机号" type="text" name="user_phone" value="" />
<hr class="hr-condensed" /><select class="form-control input-sm" placeholder="是否已验证邮箱" name="valid_mail"><option selected="selected" value="">--是否已验证邮箱--</option><option value="y">是</option><option value="n">否</option></select>
<hr class="hr-condensed" /><select class="form-control input-sm" placeholder="是否已验证手机号" name="valid_phone"><option selected="selected" value="">--是否已验证手机号--</option><option value="y">是</option><option value="n">否</option></select>
<hr class="hr-condensed" /><select class="form-control input-sm" placeholder="是否禁用" name="forbidden"><option selected="selected" value="">--是否禁用--</option><option value="y">是</option><option value="n">否</option></select>
<hr class="hr-condensed" /><select class="form-control input-sm" placeholder="" name="group_ids"><option value="1">Public</option><option value="2">|—Guest</option><option value="3">|—Manager</option><option value="6">|—|—Administrator</option><option value="4">|—Registered</option><option value="7">|—|—Author</option><option value="8">|—|—|—Editor</option><option value="9">|—|—|—|—Publisher</option><option value="5">|—Super Users</option></select>
<hr class="hr-condensed" />
<button class="btn btn-primary btn-block" type="button" name="_button_search_"><span class="glyphicon glyphicon-search"></span>查询</button>
</form></div>
<!-- /SearchBuilder -->
<script type="text/javascript">
/**
 * 提交查询表单
 * @return void
 */
$("#form_id_2").find(":button[name='_button_search_']").click(function() {
  var f = $("#form_id_2");
  var a = f.attr("action");
  var q = "";
  f.find("input").each(function() {
    if ($(this).val() != "") {
      q += "&" + $(this).attr("name") + "=" + $(this).val();
    }
  });
  f.find("select").each(function() {
    if ($(this).val() != "") {
      q += "&" + $(this).attr("name") + "=" + $(this).val();
    }
  });
  var u = a + q;
  Trotri.href(u);
});
</script>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<script type="text/javascript" src="/trotri/webroot/static/administrator/bootstrap/js/mods/ucenter.js?v=1.0"></script>

<!-- Right -->
<div class="col-xs-12 col-sm-10">
  <div class="row">

<!-- FormBuilder -->
<form class="form-horizontal" id="form_id_1" name="view" action="" method="post">
<ul class="nav nav-tabs">
<li class="active"><a data-toggle="tab" href="#main">主要信息</a></li>
<li><a data-toggle="tab" href="#groups">所属分组</a></li>
<li><a data-toggle="tab" href="#system">系统信息</a></li>
</ul><!-- /.nav nav-tabs -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><button class="btn btn-default" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=ucenter/users/index&trash=n&paged=1');" type="button" name="_button_history_back_"><span class="glyphicon glyphicon-backward"></span>返回</button>
</div>
</div><!-- /.form-group -->

<div class="tab-content">

<div id="main" class="tab-pane fade active in">
<div class="form-group">
<label class="col-lg-2 control-label">ID</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="user_id" value="1" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">登录名</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="login_name" value="aaaaaaa" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">登录方式</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="login_type" value="用户名" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">用户名</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="user_name" value="aasdff" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">用户邮箱</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="user_mail" value="" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">手机号</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="user_phone" value="" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">是否已验证邮箱</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="valid_mail" value="否" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">是否已验证手机号</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="valid_phone" value="否" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">是否禁用</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="forbidden" value="否" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">是否删除</label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="trash" value="否" />
</div>
<span class="control-label"></span>
</div>

</div><div id="groups" class="tab-pane fade">
<div class="form-group">
<label class="col-lg-2 control-label"></label>
<div class="col-lg-4">
<input class="form-control input-sm" readonly="readonly" type="text" name="group_ids" value="" />
</div>
<span class="control-label"></span>
</div>

</div><div id="system" class="tab-pane fade">
<div class="form-group">
<label class="col-lg-2 control-label">注册时间</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="dt_registered" value="2014-04-15 18:29:39" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">上次登录时间</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="dt_last_login" value="2014-04-15 18:29:39" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">上次更新密码时间</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="dt_last_repwd" value="0000-00-00 00:00:00" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">注册IP</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="ip_registered" value="0" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">上次登录IP</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="ip_last_login" value="0" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">上次更新密码IP</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="ip_last_repwd" value="0" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">总登录次数</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="login_count" value="1" />
</div>
<span class="control-label"></span>
</div>
<div class="form-group">
<label class="col-lg-2 control-label">总更新密码次数</label>
<div class="col-lg-4">
<input class="form-control input-sm" disabled="disabled" readonly="readonly" type="text" name="repwd_count" value="0" />
</div>
<span class="control-label"></span>
</div>

</div>
</div><!-- /.tab-content -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><button class="btn btn-default" onclick="return Trotri.href('/trotri/webroot/administrator.php?r=ucenter/users/index&trash=n&paged=1');" type="button" name="_button_history_back_"><span class="glyphicon glyphicon-backward"></span>返回</button>
</div>
</div><!-- /.form-group -->

</form><!-- /FormBuilder -->
<script type="text/javascript">
/**
 * 选中第一个有错误验证的Tab
 * @return void
 */
$("#form_id_1").find(".form-group").each(function() {
  if ($(this).hasClass("has-error")) {
    if ($(this).parent().hasClass("active in")) {
      return false;
    }

    $(this).parent().addClass("active in");
    $(this).parent().siblings().each(function() {
      $(this).removeClass("active in");
    });

    var id = "#" + $(this).parent().attr("id");
    $(this).parent().parent().siblings("ul").find("li").each(function() {
      if ($(this).find("a").attr("href") == id) {
        $(this).addClass("active");
      }
      else {
        $(this).removeClass("active");
      }
    });

    return false;
  }
});
</script>
  </div><!-- /.row -->
</div><!-- /.col-xs-12 col-sm-10 -->
<!-- /Right -->

  </div><!-- /.row -->

<!-- Footer -->
<hr>

<!-- Modal Dialog Trash|Remove -->
<div class="modal fade" id="dialog_trash_remove" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h2 id="dialog_trash_remove_view_body">...</h2>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="dialog_trash_remove_url">
        <input type="hidden" name="dialog_trash_remove_is_batch" value="0">
        <input type="hidden" name="dialog_trash_remove_ids" value="">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="return Core.afterDialogTrashRemove();">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<!-- /Modal Dialog Trash|Remove -->
<!-- Modal Dialog Alert -->
<div class="modal fade" id="dialog_alert" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h2 id="dialog_alert_view_body">...</h2>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<!-- /Modal Dialog Alert -->
<!-- Modal Dialog Ajax View -->
<div class="modal fade" id="dialog_ajax_view" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="dialog_ajax_view_title">查看</h4>
      </div>
      <div class="modal-body" id="dialog_ajax_view_body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<!-- /Modal Dialog Ajax View -->

<footer>
<!-- p>&copy; Company 2013</p -->
</footer>


<!-- /Footer -->

</div><!-- /.container -->

<?php $this->display('scripts'); ?>

  </body>
</html>