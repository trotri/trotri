<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
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
		),
		'columns' => array(
			'allow_other_modify',
			'title',
			'category_id',
			'sort',
			'is_head',
			'is_recommend',
			'allow_comment',
			'is_public',
			'access_count',
			'creator_name',
			'last_modifier_name',
			'dt_created',
			'dt_public',
			'dt_last_modified',
			'ip_created',
			'ip_last_modified',
			'trash',
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