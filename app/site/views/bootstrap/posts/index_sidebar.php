<!-- SideBar -->
<div class="col-sm-3 blog-sidebar">
<?php $this->widget('components\posts\DtArchives'); ?>
<?php $this->widget('components\adverts\Adverts', array('type_key' => 'friendlinks')); ?>
</div>
<!-- /SideBar -->

<?php echo $this->getHtml()->jsFile($this->js_url . '/mods/posts.js?v=' . $this->version); ?>