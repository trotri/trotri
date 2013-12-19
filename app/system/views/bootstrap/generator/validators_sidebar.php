<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'fields' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_FIELDS_INDEX_LABEL',
		'm' => 'generator', 'c' => 'fields', 'a' => 'index',
		'params' => array('generator_id' => $this->generator_id),
	),
	'validators' => array(
		'label' => 'CFG_SYSTEM_URLS_GENERATOR_VALIDATORS_INDEX_LABEL',
		'm' => 'generator', 'c' => 'validators', 'a' => 'index',
		'params' => array('field_id' => $this->field_id),
		'active' => true
	),
);

$this->widget('components\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
