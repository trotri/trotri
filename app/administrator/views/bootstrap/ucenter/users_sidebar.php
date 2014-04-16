<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'users' => array(
		'label' => 'MOD_UCENTER_URLS_USERS_INDEX',
		'm' => 'ucenter', 'c' => 'users', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_UCENTER_URLS_USERS_INDEX',
			'm' => 'ucenter', 'c' => 'users', 'a' => 'create'
		)
	),
	'groups' => array(
		'label' => 'MOD_UCENTER_URLS_GROUPS_INDEX',
		'm' => 'ucenter', 'c' => 'groups', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_UCENTER_URLS_GROUPS_INDEX',
			'm' => 'ucenter', 'c' => 'groups', 'a' => 'create'
		)
	),
	'amcas' => array(
		'label' => 'MOD_UCENTER_URLS_AMCAS_INDEX',
		'm' => 'ucenter', 'c' => 'amcas', 'a' => 'index',
	),
);

if ($this->controller === 'users') {
	$config['users']['active'] = true;
}
elseif ($this->controller === 'groups') {
	$config['groups']['active'] = true;
}
elseif ($this->controller === 'amcas') {
	$config['amcas']['active'] = true;
}

$this->widget('views\bootstrap\components\bar\SideBar', array('config' => $config));

if ($this->controller === 'users') {
	$this->widget('views\bootstrap\widgets\SearchBuilder',
		array(
			'action' => $this->getUrlManager()->getUrl('index', 'users', 'ucenter'),
			'elements' => $this->elements,
			'columns' => array(
				'login_name',
				'user_name',
				'user_mail',
				'user_phone',
				'group_ids',
				'forbidden',
				'login_type',
				'valid_mail',
				'valid_phone',
			)
		)
	);
}
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/ucenter.js?v=' . $this->version); ?>
