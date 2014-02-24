<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\elements;

use tfc\saf\Text;
use ui\ElementCollections;
use library\BuilderFactory;

/**
 * Builders class file
 * 字段信息配置类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.elements
 * @since 1.0
 */
class Builders extends ElementCollections
{
	/**
	 * @var string tbl_profile：y
	 */
	const TBL_PROFILE_Y = 'y';

	/**
	 * @var string tbl_profile：n
	 */
	const TBL_PROFILE_N = 'n';

	/**
	 * @var string tbl_engine：MyISAM
	 */
	const TBL_ENGINE_MYISAM = 'MyISAM';

	/**
	 * @var string tbl_engine：InnoDB
	 */
	const TBL_ENGINE_INNODB = 'InnoDB';

	/**
	 * @var string tbl_charset：utf8
	 */
	const TBL_CHARSET_UTF8 = 'utf8';

	/**
	 * @var string tbl_charset：gbk
	 */
	const TBL_CHARSET_GBK = 'gbk';

	/**
	 * @var string tbl_charset：gb2312
	 */
	const TBL_CHARSET_GB2312 = 'gb2312';

	/**
	 * @var string index_row_btns：pencil
	 */
	const INDEX_ROW_BTNS_PENCIL = 'pencil';

	/**
	 * @var string index_row_btns：trash
	 */
	const INDEX_ROW_BTNS_TRASH = 'trash';

	/**
	 * @var string index_row_btns：remove
	 */
	const INDEX_ROW_BTNS_REMOVE = 'remove';

	/**
	 * @var string trash：y
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string trash：n
	 */
	const TRASH_N = 'n';

	/**
	 * @var ui\bootstrap\Components 页面小组件类
	 */
	public $uiComponents = null;

	/**
	 * 构造方法：初始化页面小组件类
	 */
	public function __construct()
	{
		$this->uiComponents = BuilderFactory::getUi('Builders');
	}

	/**
	 * (non-PHPdoc)
	 * @see ui.ElementCollections::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'act' => array(
				'tid' => 'act',
				'prompt' => Text::_('MOD_BUILDER_BUILDERS_VIEWTAB_ACT_PROMPT')
			),
			'system' => array(
				'tid' => 'system',
				'prompt' => Text::_('MOD_BUILDER_BUILDERS_VIEWTAB_SYSTEM_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * 获取“主键ID”配置
	 * @param integer $type
	 * @return array
	 */
	public function getBuilderId($type)
	{
		$output = array();
		$name = 'builder_id';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“生成代码名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getBuilderName($type)
	{
		$output = array();
		$name = 'builder_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'callback' => array($this->uiComponents, 'getBuilderNameUrl')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'MinLength' => array(6, Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_MAXLENGTH')),
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“表名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTblName($type)
	{
		$output = array();
		$name = 'tbl_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'AlphaNum' => array(true, Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_ALPHANUM')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_MINLENGTH')),
				'MaxLength' => array(30, Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_MAXLENGTH')),
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“是否生成扩展表”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTblProfile($type)
	{
		$output = array();
		$options = array(
			self::TBL_PROFILE_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TBL_PROFILE_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'tbl_profile';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_LABEL'),
				'callback' => array($this->uiComponents, 'getTblProfileSwitchLabel')
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_HINT'),
				'options' => $options,
				'value' => self::TBL_PROFILE_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_LABEL'),
				'options' => $options
			);
		}

		return $output;
	}

	/**
	 * 获取“表引擎”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTblEngine($type)
	{
		$output = array();
		$options = array(
			self::TBL_ENGINE_MYISAM => self::TBL_ENGINE_MYISAM,
			self::TBL_ENGINE_INNODB => self::TBL_ENGINE_INNODB,
		);

		$name = 'tbl_engine';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_HINT'),
				'options' => $options,
				'value' => self::TBL_ENGINE_INNODB,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
				'options' => $options
			);
		}

		return $output;
	}

	/**
	 * 获取“表编码”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTblCharset($type)
	{
		$output = array();
		$options = array(
			self::TBL_CHARSET_UTF8 => self::TBL_CHARSET_UTF8,
			self::TBL_CHARSET_GBK => self::TBL_CHARSET_GBK,
			self::TBL_CHARSET_GB2312 => self::TBL_CHARSET_GB2312,
		);

		$name = 'tbl_charset';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_HINT'),
				'options' => $options,
				'value' => self::TBL_CHARSET_UTF8,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'select',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_LABEL'),
				'options' => $options
			);
		}

		return $output;
	}

	/**
	 * 获取“表描述”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTblComment($type)
	{
		$output = array();
		$name = 'tbl_comment';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'NotEmpty' => array(true, Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_NOTEMPTY')),
			);
		}

		return $output;
	}

	/**
	 * 获取“应用名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getAppName($type)
	{
		$output = array();
		$name = 'app_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_APP_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_APP_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDERS_APP_NAME_MAXLENGTH')),
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“模块名”配置
	 * @param integer $type
	 * @return array
	 */
	public function getModName($type)
	{
		$output = array();
		$name = 'mod_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_MINLENGTH')),
				'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“控制器名，默认和省略前缀的表名相同”配置
	 * @param integer $type
	 * @return array
	 */
	public function getCtrlName($type)
	{
		$output = array();
		$name = 'ctrl_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“类名，默认和省略前缀的表名相同”配置
	 * @param integer $type
	 * @return array
	 */
	public function getClsName($type)
	{
		$output = array();
		$name = 'cls_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“行动名-数据列表”配置
	 * @param integer $type
	 * @return array
	 */
	public function getActIndexName($type)
	{
		$output = array();
		$name = 'act_index_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'index',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“行动名-数据详情”配置
	 * @param integer $type
	 * @return array
	 */
	public function getActViewName($type)
	{
		$output = array();
		$name = 'act_view_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'view',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“行动名-新增数据”配置
	 * @param integer $type
	 * @return array
	 */
	public function getActCreateName($type)
	{
		$output = array();
		$name = 'act_create_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'create',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“行动名-编辑数据”配置
	 * @param integer $type
	 * @return array
	 */
	public function getActModifyName($type)
	{
		$output = array();
		$name = 'act_modify_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'modify',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_MAXLENGTH')),
			);
		}
		elseif ($type === self::TYPE_SEARCH) {
			$output = array(
				'type' => 'text',
				'placeholder' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
			);
		}

		return $output;
	}

	/**
	 * 获取“行动名-删除数据”配置
	 * @param integer $type
	 * @return array
	 */
	public function getActRemoveName($type)
	{
		$output = array();
		$name = 'act_remove_name';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'act',
				'type' => 'text',
				'value' => 'remove',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_HINT'),
				'required' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_ALPHA')),
				'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_MINLENGTH')),
				'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_MAXLENGTH')),
			);
		}

		return $output;
	}

	/**
	 * 获取“数据列表每行操作Btn，编辑：pencil、放入回收站：trash、彻底删除：remove”配置
	 * @param integer $type
	 * @return array
	 */
	public function getIndexRowBtns($type)
	{
		$output = array();
		$options = array(
			self::INDEX_ROW_BTNS_PENCIL => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
			self::INDEX_ROW_BTNS_TRASH => Text::_('CFG_SYSTEM_GLOBAL_TRASH'),
			self::INDEX_ROW_BTNS_REMOVE => Text::_('CFG_SYSTEM_GLOBAL_REMOVE'),
		);

		$name = 'index_row_btns';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'checkbox',
				'label' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_HINT'),
				'options' => $options,
				'value' => self::INDEX_ROW_BTNS_PENCIL,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

	/**
	 * 获取“描述”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDescription($type)
	{
		$output = array();
		$name = 'description';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_HINT'),
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“创建时间”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDtCreated($type)
	{
		$output = array();
		$name = 'dt_created';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“上次编辑时间”配置
	 * @param integer $type
	 * @return array
	 */
	public function getDtModified($type)
	{
		$output = array();
		$name = 'dt_modified';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_HINT'),
				'disabled' => true,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
			);
		}

		return $output;
	}

	/**
	 * 获取“是否删除”配置
	 * @param integer $type
	 * @return array
	 */
	public function getTrash($type)
	{
		$output = array();
		$options = array(
			self::TRASH_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TRASH_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);

		$name = 'trash';

		if ($type === self::TYPE_TABLE) {
			$output = array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
			);
		}
		elseif ($type === self::TYPE_FORM) {
			$output = array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TRASH_HINT'),
				'options' => $options,
				'value' => self::TRASH_N,
			);
		}
		elseif ($type === self::TYPE_FILTER) {
			$output = array(
				'InArray' => array(array_keys($options), sprintf(Text::_('MOD_BUILDER_BUILDERS_TRASH_INARRAY'), implode(', ', $options))),
			);
		}
		elseif ($type === self::TYPE_OPTIONS) {
			$output = $options;
		}

		return $output;
	}

}
