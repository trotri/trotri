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

<?php
if ($this->controller === 'posts') {
	$this->widget('views\bootstrap\widgets\SearchBuilder',
		array(
			'name' => 'create',
			'action' => $this->getUrlManager()->getUrl((($this->action == 'trashindex') ? 'trashindex' : 'index'), 'posts', 'posts'),
			'elements_object' => $this->elements,
			'elements' => array(
				'title' => array(
					'type' => 'text',
				),
				'post_id' => array(
					'type' => 'text',
				),
				'creator_id' => array(
					'type' => 'text',
				),
				'creator_name' => array(
					'type' => 'text',
				),
				'last_modifier_id' => array(
					'type' => 'text',
				),
				'last_modifier_name' => array(
					'type' => 'text',
				),
				'category_id' => array(
					'options' => $this->elements->getCategoryNames(),
				),
				'is_head' => array(
					'type' => 'select',
				),
				'is_recommend' => array(
					'type' => 'select',
				),
				'is_jump' => array(
					'type' => 'select',
				),
				'is_html' => array(
					'type' => 'select',
				),
				'allow_comment' => array(
					'type' => 'select',
				),
				'is_public' => array(
					'type' => 'select',
				),
				'access_count_start' => array(
					'type' => 'text',
				),
				'access_count_end' => array(
					'type' => 'text',
				),
			),
			'columns' => array(
				'title',
				'post_id',
				'creator_id',
				'creator_name',
				'last_modifier_id',
				'last_modifier_name',
				'category_id',
				'is_head',
				'is_recommend',
				'is_jump',
				'is_html',
				'allow_comment',
				'is_public',
				'dt_created_start',
				'dt_created_end',
				'dt_public_start',
				'dt_public_end',
				'dt_last_modified_start',
				'dt_last_modified_end',
				'access_count_start',
				'access_count_end',
			)
		)
	);
}
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/ckeditor/ckeditor.js'); ?>
<?php echo $this->getHtml()->cssFile($this->static_url . '/plugins/jquery-upload-file/uploadpreviewimg.css'); ?>
<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/jquery-upload-file/jquery.uploadfile.min.js'); ?>

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/posts.js?v=' . $this->version); ?>
