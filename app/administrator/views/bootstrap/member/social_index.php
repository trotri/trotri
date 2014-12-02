<?php
class TableRender extends views\bootstrap\components\TableRender
{
	public function getLoginNameLink($data)
	{
		return $this->elements_object->getLoginNameLink($data);
	}

	public function getHeadPortraitPreview($data)
	{
		$imgHtml = $this->html->img($data['head_portrait'], '', array('width' => 100, 'height' => 100));
		return $this->html->a($imgHtml, $data['head_portrait'], array('target' => '_blank'));
	}

	public function getSexLang($data)
	{
		return $this->elements_object->getSexLangBySex($data['sex']);
	}

	public function getOperate($data)
	{
		$params = array(
			'id' => $data['member_id'],
		);

		$modifyIcon = $this->getModifyIcon($params);
		$removeIcon = $this->getRemoveIcon($params);

		$output = $modifyIcon . $removeIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('member/social_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
			'login_name' => array(
				'callback' => 'getLoginNameLink'
			),
			'head_portrait' => array(
				'callback' => 'getHeadPortraitPreview'
			),
			'sex' => array(
				'callback' => 'getSexLang'
			),
		),
		'columns' => array(
			'login_name',
			'realname',
			'head_portrait',
			'sex',
			'birth_md',
			'telephone',
			'mobiphone',
			'email',
			'live_city',
			'address_city',
			'qq',
			'member_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('member/social_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>