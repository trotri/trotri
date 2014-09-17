<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
);
$this->widget('views\bootstrap\components\bar\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/ckeditor/ckeditor.js'); ?>
<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/posts.js?v=' . $this->version); ?>
