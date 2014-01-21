<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
<?php
$config = array(
	'fields' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELDS_INDEX_LABEL',
		'm' => 'builder', 'c' => 'fields', 'a' => 'index',
		'params' => array('builder_id' => $this->builder_id),
	),
	'validators' => array(
		'label' => 'CFG_SYSTEM_URLS_BUILDER_BUILDER_FIELD_VALIDATORS_INDEX_LABEL',
		'm' => 'builder', 'c' => 'validators', 'a' => 'index',
		'params' => array('field_id' => $this->field_id),
		'active' => true
	),
);

$this->widget('components\SideBar', array('config' => $config));
?>
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
