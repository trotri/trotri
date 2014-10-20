<?php
class TableRender extends views\bootstrap\components\TableRender
{
	public function getCategoryNameLink($data)
	{
		return $this->elements_object->getCategoryNameLink($data);
	}

	public function getPostsCount($data)
	{
		return $this->elements_object->getPostsCount($data['category_id']);
	}

	public function getSort($data)
	{
		return $this->html->text('sort[' . $data['category_id'] . ']', $data['sort'], array('class' => 'form-control input-listsort', 'size' => '5'));
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
			'posts_count' => array(
				'callback' => 'getPostsCount'
			),
			'sort' => array(
				'callback' => 'getSort'
			),
		),
		'columns' => array(
			'category_name',
			'alias',
			'meta_title',
			'tpl_home',
			'tpl_list',
			'tpl_view',
			'sort',
			'posts_count',
			'category_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('posts/categories_index_btns'); ?>