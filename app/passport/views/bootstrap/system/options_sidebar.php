<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'users_index' => array(
		'label' => 'MOD_SYSTEM_URLS_OPTIONS_MODIFY',
		'm' => 'system', 'c' => 'options', 'a' => 'modify', 'active' => true
	),
);

$this->widget('views\bootstrap\components\bar\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/system.js?v=' . $this->version); ?>
