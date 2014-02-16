<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'users' => array(
		'label' => 'CFG_SYSTEM_URLS_UCENTER_USERS_INDEX_LABEL',
		'm' => 'ucenter', 'c' => 'users', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_UCENTER_USERS_CREATE_LABEL',
			'm' => 'ucenter', 'c' => 'users', 'a' => 'create'
		)
	),
	'groups' => array(
		'label' => 'CFG_SYSTEM_URLS_UCENTER_GROUPS_INDEX_LABEL',
		'm' => 'ucenter', 'c' => 'groups', 'a' => 'index',
		'icon' => array(
			'label' => 'CFG_SYSTEM_URLS_UCENTER_GROUPS_CREATE_LABEL',
			'm' => 'ucenter', 'c' => 'groups', 'a' => 'create'
		)
	),
	'amcas' => array(
		'label' => 'CFG_SYSTEM_URLS_UCENTER_AMCAS_INDEX_LABEL',
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

$this->widget('components\SideBar', array('config' => $config));

if ($this->controller === 'users') {
	$this->widget('ui\bootstrap\widgets\SearchBuilder',
		array(
			'action' => $this->getUrlManager()->getUrl('index', 'users', 'ucenter'),
			'elementCollections' => $this->element_collections,
			'elements' => array(
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
