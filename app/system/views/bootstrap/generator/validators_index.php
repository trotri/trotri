<?php $this->display('generator/validators_index_btns'); ?>

<?php
$elements = $this->elementCollections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'columns' => array(
			'validator_name',
			'field_id',
			'options',
			'option_category',
			'message',
			'sort',
			'when',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		),
		'data' => $this->data
	)
);
?>

<?php $this->display('generator/validators_index_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
