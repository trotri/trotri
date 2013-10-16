<?php include "types_index_btns.html.php"; ?>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" name="checked_toggle" value="group_ids[]"></th>
      <th>类型名</th>
      <th>表单类型名</th>
      <th>表字段类型</th>
      <th>所属分类</th>
      <th>排序</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" name="group_ids[]" value=""></td>
      <td><a href="#">单行文本</a></td>
      <td>text</td>
      <td>VARCHAR</td>
      <td>文本类</td>
      <td>1</td>
      <td>
        <span class="glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="left" data-original-title="编辑表单字段类型" onclick="return Core.href('../generators/types_create.html.php');"></span>
        <span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" data-placement="left" data-original-title="彻底删除" onclick="return Core.dialogRemove('/remove?id=4');"></span> 
      </td>
    </tr>
  </tbody>
</table>
<?php include "types_index_btns.html.php"; ?>
<?php include "../pagination.html.php"; ?>

<?php include "../dialog_remove.html.php"; ?>
