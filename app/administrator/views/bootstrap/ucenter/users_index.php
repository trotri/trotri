<?php $this->display('ucenter/users_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\TableBuilder',
	array(
		'elements' => $this->elements,
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
			'trash',
			'user_id',
			'_operate_',
		),
		'checkedToggle' => 'user_id',
	)
);
?>

<?php $this->display('ucenter/users_index_btns'); ?>

<?php
$this->widget(
	'views\bootstrap\widgets\PaginatorBuilder',
	$this->paginator
);
?>