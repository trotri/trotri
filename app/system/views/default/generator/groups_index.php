<?php $this->display('generator/groups_index_btns'); ?>

<?php
$this->widget(
	'koala\widgets\TableBuilder',
	array(
		'elementCollections' => $this->helper,
		'columns' => array(
			'group_name',
			'generator_id',
			'sort',
			'description',
			'group_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($this->helper, 'getOperateLabel')
			),
		),
		'checkedToggle' => 'group_id',
		'data' => $this->data
	)
);
?>

<?php $this->display('generator/groups_index_btns'); ?>

<?php
$this->widget(
	'koala\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
