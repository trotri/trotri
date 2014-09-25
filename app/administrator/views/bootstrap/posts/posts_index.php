<?php
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getTitleLink($data)
	{
		return $this->elements_object->getTitleLink($data);
	}

	public function getIsHead($data)
	{
		$params = array(
			'id' => $data['post_id'],
			'column_name' => 'is_head'
		);

		$output = ComponentsBuilder::getSwitch(array(
			'id' => $data['post_id'],
			'name' => 'is_head',
			'value' => $data['is_head'],
			'href' => $this->urlManager->getUrl('singlemodify', $this->controller, $this->module, $params)
		));

		return $output;
	}

	public function getIsRecommend($data)
	{
		$params = array(
			'id' => $data['post_id'],
			'column_name' => 'is_recommend'
		);

		$output = ComponentsBuilder::getSwitch(array(
			'id' => $data['post_id'],
			'name' => 'is_recommend',
			'value' => $data['is_recommend'],
			'href' => $this->urlManager->getUrl('singlemodify', $this->controller, $this->module, $params)
		));

		return $output;
	}

	public function getIsPublic($data)
	{
		$params = array(
			'id' => $data['post_id'],
			'column_name' => 'is_public'
		);

		$output = ComponentsBuilder::getSwitch(array(
			'id' => $data['post_id'],
			'name' => 'is_public',
			'value' => $data['is_public'],
			'href' => $this->urlManager->getUrl('singlemodify', $this->controller, $this->module, $params)
		));

		return $output;
	}

	public function getOperate($data)
	{
		$params = array(
			'id' => $data['post_id'],
		);

		$modifyIcon = $this->getModifyIcon($params);
		$trashIcon = $this->getTrashIcon($params);

		$output = $modifyIcon . $trashIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('posts/posts_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
			'title' => array(
				'callback' => 'getTitleLink'
			),
			'is_head' => array(
				'callback' => 'getIsHead'
			),
			'is_recommend' => array(
				'callback' => 'getIsRecommend'
			),
			'is_public' => array(
				'callback' => 'getIsPublic'
			),
		),
		'columns' => array(
			'title',
			'category_name',
			'is_head',
			'is_recommend',
			'is_public',
			'access_count',
			'creator_name',
			'last_modifier_name',
			'dt_public',
			'sort',
			'post_id',
			'_operate_',
		),
		'checkedToggle' => 'post_id',
	)
);
?>

<?php $this->display('posts/posts_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>