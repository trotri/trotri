<?php include "users_index_btns.html.php"; ?>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" name="chkall" value="user_ids[]"></th>
      <th>邮箱</th>
      <th>用户组</th>
      <th>登录名</th>
      <th>用户名</th>
      <th>注册时间</th>
      <th>上次登录时间</th>
      <th>注册IP</th>
      <th>上次登录IP</th>
      <th>已验证邮箱</th>
      <th>封禁</th>
      <th>ID</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" name="user_ids[]" value=""></td>
      <td><a href="#">iphper@yeah.net</a></td>
      <td>管理员</td>
      <td>iphper</td>
      <td>宋欢</td>
      <td>2013-02-03 20:00:00</td>
      <td>2013-02-03 20:00:00</td>
      <td>192.168.0.1</td>
      <td>192.168.0.1</td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox" checked>
        </div>
      </td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox" checked>
        </div>
      </td>
      <td>1</td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑用户" onclick="alert('编辑用户');"></span>
        <span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="left" data-original-title="放入回收站" onclick="alert('放入回收站');"></span> 
      </td>
    </tr>
    <tr>
      <td><input type="checkbox" name="user_ids[]" value=""></td>
      <td><a href="#">iphper@yeah.net</a></td>
      <td>管理员</td>
      <td>iphper</td>
      <td>宋欢</td>
      <td>2013-02-03 20:00:00</td>
      <td>2013-02-03 20:00:00</td>
      <td>192.168.0.1</td>
      <td>192.168.0.1</td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox">
        </div>
      </td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox">
        </div>
      </td>
      <td>2</td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑用户" onclick="alert('编辑用户');"></span>
        <span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="left" data-original-title="放入回收站" onclick="alert('放入回收站');"></span> 
      </td>
    </tr>
  </tbody>
</table>
<?php include "users_index_btns.html.php"; ?>
<?php include "../pagination.html.php"; ?>
