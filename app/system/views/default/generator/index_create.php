<?php
$this->widget('widgets\FormBuilder', 
	array(
		'name' => '',
		'action' => '',
		'method' => 'post',
		'tabs' => array(
			'act' => array('tid' => 'act', 'prompt' => '行动名'),
			'system' => array('tid' => 'system', 'prompt' => '系统信息')
		),
		'elements' => array(
			'generator_name' => array(
				'type' => 'text',
				'label' => '生成代码名',
				'hint' => '生成代码名由6~12个字符组成',
				'required' => true
			),
			'tbl_name' => array(
				'type' => 'text',
				'label' => '表名',
				'hint' => '表名由2~12个英文字母、数字或下划线组成',
				'required' => true
			),
			'tbl_profile' => array(
				'type' => 'switch',
				'label' => '是否生成扩展表',
			),
			'tbl_engine' => array(
				'type' => 'radio',
				'label' => '表引擎',
				'options' => array(
					'InnoDB' => 'InnoDB',
					'MyISAM' => 'MyISAM'
				)
			),
			'tbl_charset' => array(
				'type' => 'radio',
				'label' => '表编码',
				'options' => array(
					'utf8' => 'utf8',
					'gbk' => 'gbk',
					'gb2312' => 'gb2312'
				)
			),
			'tbl_comment' => array(
				'type' => 'text',
				'label' => '表描述',
				'required' => true
			),
			'app_name' => array(
				'type' => 'text',
				'label' => '应用名',
				'hint' => '应用名由2~12个英文字母组成',
				'required' => true
			),
			'mod_name' => array(
				'type' => 'text',
				'label' => '模块名',
				'hint' => '模块名由2~12个英文字母组成',
				'required' => true
			),
			'ctrl_name' => array(
				'type' => 'text',
				'label' => '控制器名',
				'hint' => '控制器名由2~12个英文字母组成',
				'required' => true
			),
			'index_row_btns' => array(
				'type' => 'checkbox',
				'label' => '列表每行操作按钮',
				'options' => array(
					'pencil' => '编辑',
					'trash' => '放入回收站',
					'remove' => '彻底删除'
				)
			),
			'description' => array(
				'type' => 'textarea',
				'label' => '描述',
			),
			'trash' => array(
				'type' => 'switch',
				'label' => '放入回收站',
			),
			'act_index_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'index',
				'label' => '数据列表',
				'hint' => '数据列表行动名由2~12个英文字母组成',
				'required' => true
			),
			'act_view_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'view',
				'label' => '数据详情',
				'hint' => '数据详情行动名由2~12个英文字母组成',
				'required' => true
			),
			'act_create_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'create',
				'label' => '新增数据',
				'hint' => '新增数据行动名由2~12个英文字母组成',
				'required' => true
			),
			'act_modify_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'modify',
				'label' => '编辑数据',
				'hint' => '编辑数据行动名由2~12个英文字母组成',
				'required' => true
			),
			'act_remove_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'remove',
				'label' => '删除数据',
				'hint' => '删除数据行动名由2~12个英文字母组成',
				'required' => true
			),
			'creator_id' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => '创建人',
				'disabled' => true
			),
			'dt_created' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => '创建时间',
				'disabled' => true
			),
			'modifier_id' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => '上次更新人',
				'disabled' => true
			),
			'dt_modified' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => '上次更新时间',
				'disabled' => true
			),
			'button_save' => array(
				'type' => 'button',
				'label' => '保存',
				'glyphicon' => 'save',
				'class' => 'btn btn-primary'
			),
			'button_save2close' => array(
				'type' => 'button',
				'label' => '保存并关闭',
				'glyphicon' => 'ok-sign',
				'class' => 'btn btn-default'
			),
			'button_save2new' => array(
				'type' => 'button',
				'label' => '保存并新建',
				'glyphicon' => 'plus-sign',
				'class' => 'btn btn-default'
			),
			'button_cancel' => array(
				'type' => 'button',
				'label' => '取消',
				'glyphicon' => 'remove-sign',
				'class' => 'btn btn-danger'
			)
		)
	)
);
?>