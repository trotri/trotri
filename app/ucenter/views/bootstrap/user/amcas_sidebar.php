<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'users' => array(
		'label' => 'MOD_USER_URLS_USERS_INDEX',
		'm' => 'ucenter', 'c' => 'users', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_USER_URLS_USERS_INDEX',
			'm' => 'ucenter', 'c' => 'users', 'a' => 'create'
		)
	),
	'groups' => array(
		'label' => 'MOD_USER_URLS_GROUPS_INDEX',
		'm' => 'ucenter', 'c' => 'groups', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_USER_URLS_GROUPS_INDEX',
			'm' => 'ucenter', 'c' => 'groups', 'a' => 'create'
		)
	),
	'amcas' => array(
		'label' => 'MOD_USER_URLS_AMCAS_INDEX',
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
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
