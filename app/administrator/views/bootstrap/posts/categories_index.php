<?php
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getCategoryNameLink($data)
	{
		return $this->elements_object->getCategoryNameLink($data);
	}

	public function getModuleName($data)
	{
		return $this->elements_object->getModuleNameByModuleId($data['module_id']);
	}

	public function getIsHide($data)
	{
		$params = array(
			'id' => $data['category_id'],
			'column_name' => 'is_hide'
		);

		$output = ComponentsBuilder::getSwitch(array(
			'id' => $data['category_id'],
			'name' => 'is_hide',
			'value' => $data['is_hide'],
			'href' => $this->urlManager->getUrl('singlemodify', $this->controller, $this->module, $params)
		));

		return $output;
	}

	public function getIsHtml($data)
	{
		$params = array(
			'id' => $data['category_id'],
			'column_name' => 'is_html'
		);

		$output = ComponentsBuilder::getSwitch(array(
			'id' => $data['category_id'],
			'name' => 'is_html',
			'value' => $data['is_html'],
			'href' => $this->urlManager->getUrl('singlemodify', $this->controller, $this->module, $params)
		));

		return $output;
	}

	public function getMenuSort($data)
	{
		return $this->html->text('menu_sort[' . $data['category_id'] . ']', $data['menu_sort'], array('size' => 6));
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
			'module_id' => array(
				'callback' => 'getModuleName'
			),
			'is_hide' => array(
				'callback' => 'getIsHide'
			),
			'is_html' => array(
				'callback' => 'getIsHtml'
			),
			'menu_sort' => array(
				'callback' => 'getMenuSort'
			),
		),
		'columns' => array(
			'category_name',
			'module_id',
			'is_hide',
			'menu_sort',
			'is_html',
			'category_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('posts/categories_index_btns'); ?>
