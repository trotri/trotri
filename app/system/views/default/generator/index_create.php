<?php
$form = $this->util->getForm('Generators', 'generator');
$type = $form::TYPE_FORM;
$this->widget('widgets\FormBuilder', 
	array(
		'name' => '',
		'action' => '',
		'method' => 'post',
		'tabs' => $form::$tabs,
		'elements' => array(
			'generator_name' => $form->getGeneratorName($type),
			'tbl_name' => $form->getTblName($type),
			'tbl_profile' => $form->getTblProfile($type),
			'tbl_engine' => $form->getTblEngine($type),
			'tbl_charset' => $form->getTblCharset($type),
			'tbl_comment' => $form->getTblComment($type),
			'app_name' => $form->getAppName($type),
			'mod_name' => $form->getModName($type),
			'ctrl_name' => $form->getCtrlName($type),
			'index_row_btns' => $form->getIndexRowBtns($type),
			'description' => $form->getDescription($type),
			'trash' => $form->getTrash($type),
			'act_index_name' => $form->getActIndexName($type),
			'act_view_name' => $form->getActViewName($type),
			'act_create_name' => $form->getActCreateName($type),
			'act_modify_name' => $form->getActModifyName($type),
			'act_remove_name' => $form->getActRemoveName($type),
			'creator_id' => $form->getCreatorId($type),
			'dt_created' => $form->getDtCreated($type),
			'modifier_id' => $form->getModifierId($type),
			'dt_modified' => $form->getDtModified($type),
			'button_save' => array(
				'className' => 'ButtonElement',
				'config' => array(
					'label' => '保存',
					'glyphicon' => 'save',
					'class' => 'btn btn-primary'
				)
			),
			'button_save2close' => array(
				'className' => 'ButtonElement',
				'config' => array(
					'label' => '保存并关闭',
					'glyphicon' => 'ok-sign',
					'class' => 'btn btn-default'
				)
			),
			'button_save2new' => array(
				'className' => 'ButtonElement',
				'config' => array(
					'label' => '保存并新建',
					'glyphicon' => 'plus-sign',
					'class' => 'btn btn-default'
				)
			),
			'button_cancel' => array(
				'className' => 'ButtonElement',
				'config' => array(
					'label' => '取消',
					'glyphicon' => 'remove-sign',
					'class' => 'btn btn-danger'
				)
			)
		)
	)
);
?>