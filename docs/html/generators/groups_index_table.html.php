<?php include "groups_index_btns.html.php"; ?>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" name="chkall" value="group_ids[]"></th>
      <th>组名</th>
      <th>生成代码名</th>
      <th>排序</th>
      <th>描述</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" name="group_ids[]" value=""></td>
      <td><a href="#">主要信息</a></td>
      <td>公共组</td>
      <td>1</td>
      <td></td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑表单字段组" onclick="return Core.href('../generators/groups_create.html.php');"></span>
        <span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" data-original-title="彻底删除" onclick="return Core.dialogRemove('/remove?id=4');"></span> 
      </td>
    </tr>
    <tr>
      <td><input type="checkbox" name="group_ids[]" value=""></td>
      <td><a href="#">扩展信息</a></td>
      <td>公共组</td>
      <td>2</td>
      <td></td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑表单字段组" onclick="return Core.href('../generators/groups_create.html.php');"></span>
        <span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" data-original-title="彻底删除" onclick="return Core.dialogRemove('/remove?id=4');"></span> 
      </td>
    </tr>
    <tr>
      <td><input type="checkbox" name="group_ids[]" value=""></td>
      <td><a href="#">行动名</a></td>
      <td>generators</td>
      <td>3</td>
      <td></td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑表单字段组" onclick="return Core.href('../generators/groups_create.html.php');"></span>
        <span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" data-original-title="彻底删除" onclick="return Core.dialogRemove('/remove?id=4');"></span> 
      </td>
    </tr>
  </tbody>
</table>
<?php include "groups_index_btns.html.php"; ?>
<?php include "../pagination.html.php"; ?>

<?php include "../dialog_remove.html.php"; ?>
