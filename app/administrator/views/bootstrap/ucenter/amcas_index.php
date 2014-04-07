<?php $this->display('ucenter/amcas_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
		'data' => $this->data,
		'columns' => array(
			'amca_name',
			'amca_pid',
			'amca_pname',
			'prompt',
			'sort',
			'category',
			'amca_id',
			'_operate_',
		),
		'checkedToggle' => 'amca_id',
	)
);
?>

<?php $this->display('ucenter/amcas_index_btns'); ?>
