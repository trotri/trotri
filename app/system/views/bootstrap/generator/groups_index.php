<?php $this->display('generator/groups_index_btns'); ?>

<?php
$elements = $this->elementCollections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'columns' => array(
			'group_name',
			'generator_id',
			'sort',
			'description',
			'group_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		),
		'data' => $this->data
	)
);
?>

<?php $this->display('generator/groups_index_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
