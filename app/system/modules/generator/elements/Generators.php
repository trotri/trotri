<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\elements;

use tfc\saf\Text;
use ui\ElementCollections;

/**
 * Generators class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.elements
 * @since 1.0
 */
class Generators extends ElementCollections
{
	/**
	 * @var string 数据库表引擎：InnoDB类型
	 */
	const TBL_ENGINE_INNODB = 'InnoDB';

	/**
	 * @var string 数据库表引擎：MyISAM类型
	 */
	const TBL_ENGINE_MYISAM = 'MyISAM';

	/**
	 * @var string 数据库表编码方式：utf8
	 */
	const TBL_CHARSET_UTF8 = 'utf8';

	/**
	 * @var string 数据库表编码方式：gbk
	 */
	const TBL_CHARSET_GBK = 'gbk';

	/**
	 * @var string 数据库表编码方式：gb2312
	 */
	const TBL_CHARSET_GB2312 = 'gb2312';

	/**
	 * @var string 是否生成扩展表：是
	 */
	const TBL_PROFILE_Y = 'y';

	/**
	 * @var string 是否生成扩展表：否
	 */
	const TBL_PROFILE_N = 'n';

	/**
	 * @var string 选择是否删除：是
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string 选择是否删除：否
	 */
	const TRASH_N = 'n';

	/**
	 * @var string 数据列表每行操作Btn：更新
	 */
	const INDEX_ROW_BTNS_PENCIL = 'pencil';

	/**
	 * @var string 数据列表每行操作Btn：放入回收站
	 */
	const INDEX_ROW_BTNS_TRASH = 'trash';

	/**
	 * @var string 数据列表每行操作Btn：彻底删除
	 */
	const INDEX_ROW_BTNS_REMOVE = 'remove';

	/**
	 * (non-PHPdoc)
	 * @see ui.ElementCollections::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'act' => array(
				'tid' => 'act', 
				'prompt' => Text::_('MOD_GENERATOR_GENERATORS_VIEWTAB_ACT_PROMPT')
			),
			'system' => array(
				'tid' => 'system', 
				'prompt' => Text::_('MOD_GENERATOR_GENERATORS_VIEWTAB_SYSTEM_PROMPT')
			)
		);

		return $output;
	}

	/**
	 * 获取“生成代码ID”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGeneratorId($type)
	{
		$output = array();

		$name = 'generator_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => 'ID'
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => 'ID'
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getGeneratorName($type)
	{
		$output = array();

		$name = 'generator_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL'),
				'callback' => array($this->getUiComponentsInstance(), 'getGeneratorNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(6, Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_MAXLENGTH'))
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_GENERATOR_GENERATORS_GENERATOR_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“表名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblName($type)
	{
		$output = array();

		$name = 'tbl_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'AlphaNum' => array(true, Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_ALPHANUM')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_MAXLENGTH'))
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_GENERATOR_GENERATORS_TBL_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“是否生成扩展表”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblProfile($type)
	{
		$output = array();

		$tblProfiles = array(
			self::TBL_PROFILE_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TBL_PROFILE_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'tbl_profile';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_PROFILE_LABEL'),
				'callback' => array($this->getUiComponentsInstance(), 'getTblProfileSwitchLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'switch',
				'value' => self::TBL_PROFILE_N,
				'options' => $tblProfiles,
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_PROFILE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($tblProfiles),
					sprintf(Text::_('MOD_GENERATOR_GENERATORS_TBL_PROFILE_INARRAY'), implode('、', $tblProfiles))
				)
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_GENERATOR_GENERATORS_TBL_PROFILE_LABEL'),
				'options' => $tblProfiles,
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $tblProfiles;
		}

		return $output;
	}

	/**
	 * 获取“表引擎”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblEngine($type)
	{
		$output = array();

		$tblEngines = array(
			self::TBL_ENGINE_INNODB => self::TBL_ENGINE_INNODB,
			self::TBL_ENGINE_MYISAM => self::TBL_ENGINE_MYISAM
		);

		$name = 'tbl_engine';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_ENGINE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'value' => self::TBL_ENGINE_INNODB,
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_ENGINE_LABEL'),
				'options' => $tblEngines
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($tblEngines),
					sprintf(Text::_('MOD_GENERATOR_GENERATORS_TBL_ENGINE_INARRAY'), implode('、', $tblEngines))
				)
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_GENERATOR_GENERATORS_TBL_ENGINE_LABEL'),
				'options' => $tblEngines
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $tblEngines;
		}

		return $output;
	}

	/**
	 * 获取“表编码”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblCharset($type)
	{
		$output = array();

		$tblCharsets = array(
			self::TBL_CHARSET_UTF8 => self::TBL_CHARSET_UTF8,
			self::TBL_CHARSET_GBK => self::TBL_CHARSET_GBK,
			self::TBL_CHARSET_GB2312 => self::TBL_CHARSET_GB2312
		);

		$name = 'tbl_charset';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_CHARSET_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'radio',
				'value' => self::TBL_CHARSET_UTF8,
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_CHARSET_LABEL'),
				'options' => $tblCharsets
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($tblCharsets),
					sprintf(Text::_('MOD_GENERATOR_GENERATORS_TBL_CHARSET_INARRAY'), implode('、', $tblCharsets))
				)
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_GENERATOR_GENERATORS_TBL_CHARSET_LABEL'),
				'options' => $tblCharsets
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $tblCharsets;
		}

		return $output;
	}

	/**
	 * 获取“表描述”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTblComment($type)
	{
		$output = array();

		$name = 'tbl_comment';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_COMMENT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TBL_COMMENT_LABEL'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'NotEmpty' => array(true, Text::_('MOD_GENERATOR_GENERATORS_TBL_COMMENT_NOTEMPTY'))
			);
		}

		return $output;
	}

	/**
	 * 获取“应用名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getAppName($type)
	{
		$output = array();

		$name = 'app_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_MAXLENGTH'))
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_GENERATOR_GENERATORS_APP_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“模块名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getModName($type)
	{
		$output = array();

		$name = 'mod_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_MOD_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_MOD_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_MOD_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_MOD_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_MOD_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_MOD_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“控制器名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getCtrlName($type)
	{
		$output = array();

		$name = 'ctrl_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_CTRL_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_CTRL_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_CTRL_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_CTRL_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_CTRL_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_CTRL_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“列表每行操作按钮”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getIndexRowBtns($type)
	{
		$output = array();

		$indexRowBtns = array(
			self::INDEX_ROW_BTNS_PENCIL => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
			self::INDEX_ROW_BTNS_TRASH => Text::_('CFG_SYSTEM_GLOBAL_TRASH'),
			self::INDEX_ROW_BTNS_REMOVE => Text::_('CFG_SYSTEM_GLOBAL_REMOVE')
		);

		$name = 'index_row_btns';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_INDEX_ROW_BTNS_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'checkbox',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_INDEX_ROW_BTNS_LABEL'),
				'options' => $indexRowBtns
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($indexRowBtns),
					sprintf(Text::_('MOD_GENERATOR_GENERATORS_INDEX_ROW_BTNS_INARRAY'), implode('、', $indexRowBtns))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $indexRowBtns;
		}

		return $output;
	}

	/**
	 * 获取“描述”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDescription($type)
	{
		$output = array();

		$name = 'description';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_DESCRIPTION_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'textarea',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_DESCRIPTION_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“放入回收站”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getTrash($type)
	{
		$output = array();

		$trashs = array(
			self::TRASH_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TRASH_N => Text::_('CFG_SYSTEM_GLOBAL_NO')
		);

		$name = 'trash';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TRASH_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'type' => 'switch',
				'value' => self::TRASH_N,
				'label' => Text::_('MOD_GENERATOR_GENERATORS_TRASH_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(
					array_keys($trashs),
					sprintf(Text::_('MOD_GENERATOR_GENERATORS_TRASH_INARRAY'), implode('、', $trashs))
				)
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $trashs;
		}

		return $output;
	}

	/**
	 * 获取“数据列表行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActIndexName($type)
	{
		$output = array();

		$name = 'act_index_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_INDEX_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'index',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_INDEX_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_ACT_INDEX_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_ACT_INDEX_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_ACT_INDEX_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_ACT_INDEX_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“数据详情行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActViewName($type)
	{
		$output = array();

		$name = 'act_view_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_VIEW_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'view',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_VIEW_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_ACT_VIEW_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_ACT_VIEW_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_ACT_VIEW_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_ACT_VIEW_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“新增数据行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActCreateName($type)
	{
		$output = array();

		$name = 'act_create_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_CREATE_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'create',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_CREATE_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_ACT_CREATE_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_ACT_CREATE_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_ACT_CREATE_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_ACT_CREATE_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“编辑数据行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActModifyName($type)
	{
		$output = array();

		$name = 'act_modify_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_MODIFY_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'modify',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_MODIFY_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_ACT_MODIFY_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_ACT_MODIFY_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_ACT_MODIFY_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_ACT_MODIFY_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“编删除数据行动名”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getActRemoveName($type)
	{
		$output = array();

		$name = 'act_remove_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_REMOVE_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'remove',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_ACT_REMOVE_NAME_LABEL'),
				'hint' => Text::_('MOD_GENERATOR_GENERATORS_ACT_REMOVE_NAME_HINT'),
				'required' => true
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_GENERATOR_GENERATORS_ACT_REMOVE_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_GENERATOR_GENERATORS_ACT_REMOVE_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_GENERATOR_GENERATORS_ACT_REMOVE_NAME_MAXLENGTH'))
			);
		}

		return $output;
	}

	/**
	 * 获取“创建人”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getCreatorId($type)
	{
		$output = array();

		$name = 'creator_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_CREATOR_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_CREATOR_ID_LABEL'),
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取“创建时间”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDtCreated($type)
	{
		$output = array();

		$name = 'dt_created';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_DT_CREATED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_DT_CREATED_LABEL'),
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取“上次更新人”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getModifierId($type)
	{
		$output = array();

		$name = 'modifier_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_MODIFIER_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_MODIFIER_ID_LABEL'),
				'disabled' => true
			);
		}

		return $output;
	}

	/**
	 * 获取“上次更新时间”表单元素和验证规则
	 * @param integer $type
	 * @return array
	 */
	public function getDtModified($type)
	{
		$output = array();

		$name = 'dt_modified';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_GENERATOR_GENERATORS_DT_MODIFIED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_GENERATOR_GENERATORS_DT_MODIFIED_LABEL'),
				'disabled' => true
			);
		}

		return $output;
	}
}