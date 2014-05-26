<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getOperate($data)
	{
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('builder/builders_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
		),
		'columns' => array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'app_name',
			'mod_name',
			'cls_name',
			'ctrl_name',
			'builder_id',
			'_operate_',
		),
		'checkedToggle' => 'builder_id',
	)
);
?>

<?php $this->display('builder/builders_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>