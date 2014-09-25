<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'posts_index' => array(
		'label' => 'MOD_POSTS_URLS_POSTS_INDEX',
		'm' => 'posts', 'c' => 'posts', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_POSTS_URLS_POSTS_CREATE',
			'm' => 'posts', 'c' => 'posts', 'a' => 'create'
		)
	),
	'posts_trashindex' => array(
		'label' => 'MOD_POSTS_URLS_POSTS_TRASHINDEX',
		'm' => 'posts', 'c' => 'posts', 'a' => 'trashindex'
	),
	'categories' => array(
		'label' => 'MOD_POSTS_URLS_CATEGORIES_INDEX',
		'm' => 'posts', 'c' => 'categories', 'a' => 'index',
		'icon' => array(
			'label' => 'MOD_POSTS_URLS_CATEGORIES_CREATE',
			'm' => 'posts', 'c' => 'categories', 'a' => 'create'
		)
	),
	'modules' => array(
		'label' => 'MOD_POSTS_URLS_MODULES_INDEX',
		'm' => 'posts', 'c' => 'modules', 'a' => 'index',
	)
);

if ($this->controller === 'posts') {
	if ($this->action === 'trashindex') {
		$config['posts_trashindex']['active'] = true;
	}
	else {
		$config['posts_index']['active'] = true;
	}
}
elseif ($this->controller === 'categories') {
	$config['categories']['active'] = true;
}
elseif ($this->controller === 'modules') {
	$config['modules']['active'] = true;
}

$this->widget('views\bootstrap\components\bar\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/ckeditor/ckeditor.js'); ?>
<?php echo $this->getHtml()->cssFile($this->static_url . '/plugins/jquery-upload-file/uploadpreviewimg.css'); ?>
<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/jquery-upload-file/jquery.uploadfile.min.js'); ?>

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/posts.js?v=' . $this->version); ?>
