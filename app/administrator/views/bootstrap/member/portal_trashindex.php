<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getOperate($data)
	{
		$params = array(
			'id' => $data['member_id'],
		);

		$restoreIcon = $this->getRestoreIcon($params);
		$removeIcon = $this->getRemoveIcon($params);

		$output = $restoreIcon . $removeIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('member/portal_trashindex_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
		),
		'columns' => array(
			'login_name',
			'member_name',
			'member_mail',
			'member_phone',
			'dt_registered',
			'dt_last_login',
			'dt_last_repwd',
			'ip_registered',
			'ip_last_login',
			'ip_last_repwd',
			'login_count',
			'repwd_count',
			'valid_mail',
			'valid_phone',
			'forbidden',
			'trash',
			'member_id',
			'_operate_',
		),
		'checkedToggle' => 'member_id',
	)
);
?>

<?php $this->display('member/portal_trashindex_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>