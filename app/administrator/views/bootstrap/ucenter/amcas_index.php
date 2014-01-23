<?php $this->display('ucenter/amcas_index_btns'); ?>

<?php
$elements = $this->element_collections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'data' => $this->data,
		'columns' => array(
			'amca_name',
			'prompt',
			'amca_pid',
			'sort',
			'category',
			'amca_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		)
	)
);
?>

<?php $this->display('ucenter/amcas_index_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/administrator/js/ucenter.js'); ?>
