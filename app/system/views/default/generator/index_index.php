<?php $this->display('generator/index_index_btns'); ?>

<?php
$this->widget(
	'koala\widgets\TableBuilder',
	array(
		'elementCollections' => $this->helper,
		'columns' => array(
			'generator_name',
			'tbl_name',
			'tbl_profile',
			'tbl_engine',
			'tbl_charset',
			'tbl_comment',
			'app_name',
			'mod_name',
			'ctrl_name',
			'generator_field_groups' => array(
				'name' => 'generator_field_groups',
				'label' => '字段组',
				'callback' => array($this->helper, 'getGeneratorFieldGroupsLabel')
			),
			'generator_field_types' => array(
				'name' => 'generator_field_types',
				'label' => '字段类型',
				'callback' => array($this->helper, 'getGeneratorFieldTypesLabel')
			),
			'generator_fields' => array(
				'name' => 'generator_fields',
				'label' => '字段管理',
				'callback' => array($this->helper, 'getGeneratorFieldsLabel')
			),
			'generator_id' => array(
				'label' => 'ID',
			),
			'operate' => array(
				'label' => '操作',
				'callback' => array($this->helper, 'getOperateLabel')
			),
		),
		'checkedToggle' => 'generator_id',
		'data' => $this->data
		// 'dataProvider' => 
	)
);
?>

<?php $this->display('generator/index_index_btns'); ?>

<?php $this->widget('koala\widgets\PaginatorBuilder', $this->paginator); ?>

<?php echo $this->getHtml()->jsFile($this->base_url . '/static/system/js/generator.js'); ?>
