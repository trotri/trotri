<?php
class TableRender extends views\bootstrap\components\TableRender
{
	public function getIsHead($data)
	{
		return $this->elements_object->getIsHeadLangByIsHead($data['is_head']);
	}

	public function getIsRecommend($data)
	{
		return $this->elements_object->getIsRecommendLangByIsRecommend($data['is_recommend']);
	}

	public function getIsPublic($data)
	{
		return $this->elements_object->getIsPublicLangByIsPublic($data['is_public']);
	}

	public function getOperate($data)
	{
		$params = array(
			'id' => $data['post_id'],
		);

		$restoreIcon = $this->getRestoreIcon($params);
		$removeIcon = $this->getRemoveIcon($params);

		$output = $restoreIcon . $removeIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('posts/posts_trashindex_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
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

<?php $this->display('posts/posts_trashindex_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>