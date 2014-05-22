<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;
use builder\models\DataBuilders;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getBuilderNameLink($data)
	{
		return $this->elements_object->getBuilderNameLink($data);
	}

	public function getTblProfile($data)
	{
		$enum = DataBuilders::getTblProfileEnum();
		return $enum[$data['tbl_profile']];
	}

	public function getOperate($data)
	{
		$params = array('id' => $data['builder_id']);
		$removeIcon = $this->getRemoveIcon($params);
		$restoreIcon = $this->getRestoreIcon($params);

		$output = $restoreIcon . $removeIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('builder/builders_trashindex_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
			'builder_name' => array(
				'callback' => 'getBuilderNameLink'
			),
			'tbl_profile' => array(
				'callback' => 'getTblProfile'
			),
		),
		'columns' => array(
			'builder_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'app_name',
			'mod_name',
			'ctrl_name',
			'cls_name',
			'builder_id',
			'_operate_',
		),
		'checkedToggle' => 'builder_id',
	)
);
?>

<?php $this->display('builder/builders_trashindex_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>