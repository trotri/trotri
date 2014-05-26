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

<?php $this->display('builder/types_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
		),
		'columns' => array(
			'type_name',
			'form_type',
			'field_type',
			'category',
			'sort',
			'type_id',
			'_operate_',
		),
		'checkedToggle' => 'type_id',
	)
);
?>

<?php $this->display('builder/types_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>