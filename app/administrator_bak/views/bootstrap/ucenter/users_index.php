<?php $this->display('ucenter/users_index_btns'); ?>

<?php
$elements = $this->element_collections;
$this->widget(
	'ui\bootstrap\widgets\TableBuilder',
	array(
		'elementCollections' => $elements,
		'data' => $this->data,
		'columns' => array(
			'login_name',
			'user_name',
			'user_mail',
			'user_phone',
			'valid_mail',
			'valid_phone',
			'dt_registered',
			'dt_last_login',
			'ip_registered',
			'forbidden',
			'user_id',
			'operate' => array(
				'label' => $this->CFG_SYSTEM_GLOBAL_OPERATE,
				'callback' => array($elements->uiComponents, 'getOperate')
			),
		),
		'checkedToggle' => 'user_id',
	)
);
?>

<?php $this->display('ucenter/users_index_btns'); ?>

<?php
$this->widget(
	'ui\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>

<?php $this->display('dialogs/alert'); ?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/administrator/js/ucenter.js'); ?>
