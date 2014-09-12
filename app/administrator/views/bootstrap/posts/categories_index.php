<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getCategoryNameLink($data)
	{
		return $this->elements_object->getCategoryNameLink($data);
	}

	public function getOperate($data)
	{
		$params = array(
			'id' => $data['category_id'],
		);

		$modifyIcon = $this->getModifyIcon($params);
		$removeIcon = $this->getRemoveIcon($params);

		$output = $modifyIcon . $removeIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('posts/categories_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
			'category_name' => array(
				'callback' => 'getCategoryNameLink'
			),
		),
		'columns' => array(
			'category_name',
			'category_pid',
			'module_id',
			'is_hide',
			'menu_sort',
			'is_jump',
			'is_html',
			'category_id',
			'_operate_',
		),
		'checkedToggle' => 'category_id',
	)
);
?>

<?php $this->display('posts/categories_index_btns'); ?>
