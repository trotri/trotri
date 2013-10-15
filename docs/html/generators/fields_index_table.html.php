<?php include "fields_index_btns.html.php"; ?>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" name="chkall" value="field_ids[]"></th>
      <th>字段名</th>
      <th>字段类型</th>
      <th>表单字段组</th>
      <th>Label</th>
      <th>必填</th>
      <th>允许更新</th>
      <th>列表排序</th>
      <th>新增排序</th>
      <th>更新排序</th>
      <th>查询排序</th>
      <th>ID</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" name="field_ids[]" value=""></td>
      <td><a href="#">user_id</a></td>
      <td>自增主键 BIGINT(20)</td>
      <td>主要信息</td>
      <td>主键ID</td>
      <td>否</td>
      <td>否</td>
      <td>100</td>
      <td>不展示</td>
      <td>不展示</td>
      <td>不展示</td>
      <td>1</td>
      <td>
        <span class="glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="left" data-original-title="查看验证规则"></span>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑表单字段" onclick="return Core.href('../generators/fields_create.html.php');"></span>
        <span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" data-original-title="彻底删除" onclick="alert('彻底删除');"></span> 
      </td>
    </tr>
    <tr>
      <td><input type="checkbox" name="field_ids[]" value=""></td>
      <td><a href="#">login_email</a></td>
      <td>单行文本 text VARCHAR(100)</td>
      <td>主要信息</td>
      <td>登录邮箱</td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox" checked>
        </div>
      </td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox">
        </div>
      </td>
      <td>100</td>
      <td>1</td>
      <td>1</td>
      <td>1</td>
      <td>1</td>
      <td>
        <span class="glyphicon glyphicon-comment" data-toggle="tooltip" data-placement="left" data-original-title="查看验证规则"></span>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑表单字段" onclick="return Core.href('../generators/fields_create.html.php');"></span>
        <span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" data-original-title="彻底删除" onclick="alert('彻底删除');"></span> 
      </td>
    </tr>
  </tbody>
</table>
<?php include "fields_index_btns.html.php"; ?>
<?php include "../pagination.html.php"; ?>
