<?php $this->display('generator/groups_index_btns'); ?>

<?php
$elementCollections = $this->elementCollections;
$uiComponents = $elementCollections->getUiComponentsInstance();
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elementCollections,
		'columns' => array(
			'group_name',
			'generator_id',
			'sort',
			'description',
			'group_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($uiComponents, 'getOperateLabel')
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
