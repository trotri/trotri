<?php $this->display('ucenter/amcas_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'amca_name',
			'prompt',
			'sort',
			'category',
			'amca_id',
			'_operate_',
		),
	)
);
?>

<?php $this->display('ucenter/amcas_index_btns'); ?>
