<?php $this->display('generator/index_index_btns'); ?>

<?php
$this->widget(
	'widgets\TableBuilder',
	array(
		'helper' => $this->util->getHelper('Generators', 'generator'),
		'columns' => array(
			'generator_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'creator_id',
			'generator_field_groups' => array(
				'name' => 'generator_field_groups',
				'label' => '字段组',
				'callback' => array()
			),
			'generator_field_types' => array(
				'name' => 'generator_field_types',
				'label' => '字段类型',
				'callback' => array()
			),
			'generator_fields' => array(
				'name' => 'generator_fields',
				'label' => '字段管理',
				'callback' => array()
			),
			'generator_id' => array(
				'label' => 'ID',
				'callback' => array()
			),
		),
		'checkedToggle' => 'generator_ids',
		'data' => array(
			array(
				'generator_name' => 'a1',
				'tbl_name' => 'a2',
				'tbl_profile' => 'a3',
				'tbl_engine' => 'a4',
				'tbl_charset' => 'a5',
				'tbl_comment' => 'a6',
				'app_name' => 'a7',
				'mod_name' => 'a8',
				'ctrl_name' => 'a9',
				'creator_id' => 'a10'
			),
			array(
				'generator_name' => 'b1',
				'tbl_name' => 'b2',
				'tbl_profile' => 'b3',
				'tbl_engine' => 'b4',
				'tbl_charset' => 'b5',
				'tbl_comment' => 'b6',
				'app_name' => 'b7',
				'mod_name' => 'b8',
				'ctrl_name' => 'b9',
				'creator_id' => 'b10'
			),
		),
		// 'dataProvider' => 
	)
);
?>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th><input type="checkbox" name="checked_toggle" value="generator_ids[]"></th>
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
<?php $this->display('generator/index_index_btns'); ?>
<?php $this->display('paginator'); ?>
<?php $this->display('dialogs/trash'); ?>
