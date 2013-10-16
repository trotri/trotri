<?php include "generators_index_btns.html.php"; ?>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" name="chkall" value="generator_ids[]"></th>
      <th>生成代码名</th>
      <th>表名</th>
      <th>生成扩展表</th>
      <th>表引擎</th>
      <th>表编码</th>
      <th>表描述</th>
      <th>应用名</th>
      <th>模块名</th>
      <th>控制器名</th>
      <th>创建人</th>
      <th>字段组</th>
      <th>字段类型</th>
      <th>字段管理</th>
      <th>ID</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" name="generator_ids[]" value=""></td>
      <td><a href="#">用户管理</a></td>
      <td>users</td>
      <td>
        <div id="label-switch" class="make-switch switch-small" data-on-label="是" data-off-label="否">
          <input type="checkbox" checked>
        </div>
      </td>
      <td>InnoDB</td>
      <td>utf8</td>
      <td>用户主表</td>
      <td>ucenter</td>
      <td>administrator</td>
      <td>users</td>
      <td>SongHuan</td>
      <td>
        <span class="glyphicon glyphicon-list" data-toggle="tooltip" data-placement="left" data-original-title="浏览表单字段组" onclick="return Core.href('../generators/groups_index.html.php');"></span>
        <span class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="left" data-original-title="新增表单字段组" onclick="return Core.href('../generators/groups_create.html.php');"></span>
      </td>
      <td>
        <span class="glyphicon glyphicon-list" data-toggle="tooltip" data-placement="left" data-original-title="浏览表单字段类型" onclick="return Core.href('../generators/fields_index.html.php');"></span>
        <span class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="left" data-original-title="新增表单字段类型" onclick="return Core.href('../generators/fields_create.html.php');"></span>
      </td>
      <td>
        <span class="glyphicon glyphicon-list" data-toggle="tooltip" data-placement="left" data-original-title="浏览表单字段" onclick="return Core.href('../generators/fields_index.html.php');"></span>
        <span class="glyphicon glyphicon-plus-sign" data-toggle="tooltip" data-placement="left" data-original-title="新增表单字段" onclick="return Core.href('../generators/fields_create.html.php');"></span>
      </td>
      <td>1</td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑生成代码" onclick="alert('编辑生成代码');"></span>
        <span class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="left" data-original-title="移至回收站" onclick="return Core.dialogTrash('/trash?id=1');"></span> 
      </td>
    </tr>
  </tbody>
</table>
<?php include "generators_index_btns.html.php"; ?>
<?php include "../pagination.html.php"; ?>

<?php include "../dialog_trash.html.php"; ?>
