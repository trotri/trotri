<?php
use views\bootstrap\components\ComponentsConstant;
use views\bootstrap\components\ComponentsBuilder;

class TableRender extends views\bootstrap\components\TableRender
{
	public function getAdvertNameLink($data)
	{
		return $this->elements_object->getAdvertNameLink($data);
	}

	public function getOperate($data)
	{
		$params = array(
			'id' => $data['advert_id'],
			'type_key' => $data['type_key']
		);

		$modifyIcon = $this->getModifyIcon($params);
		$removeIcon = $this->getRemoveIcon($params);

		$output = $modifyIcon . $removeIcon;
		return $output;
	}
}

$tblRender = new TableRender($this->elements);
?>

<?php $this->display('advert/adverts_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'data' => $this->data,
		'table_render' => $tblRender,
		'elements' => array(
			'advert_name' => array(
				'callback' => 'getAdvertNameLink'
			),
		),
		'columns' => array(
			'advert_name',
			'type_key',
			'description',
			'is_published',
			'dt_publish_up',
			'dt_publish_down',
			'sort',
			'show_type',
			'show_code',
			'title',
			'advert_url',
			'advert_src',
			'advert_src2',
			'attr_alt',
			'attr_width',
			'attr_height',
			'attr_fontsize',
			'attr_target',
			'dt_created',
			'advert_id',
			'_operate_',
		),
		'checkedToggle' => 'advert_id',
	)
);
?>

<?php $this->display('advert/adverts_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>