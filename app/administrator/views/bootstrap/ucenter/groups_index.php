<?php $this->display('ucenter/groups_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'group_name',
			// 'group_pid',
			'sort',
			'permission',
			'description',
			'group_id',
			'_operate_',
		),
		// 'checkedToggle' => 'group_id',
	)
);
?>

<?php $this->display('ucenter/groups_index_btns'); ?>
