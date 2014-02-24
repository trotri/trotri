<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\data;

use tfc\saf\Text;

/**
 * BuildersData class file
 * 寄存Builders模块常量、选项、验证数据类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: BuildersData.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.data
 * @since 1.0
 */
class BuildersData
{
	/**
	 * @var string 是否生成扩展表：是
	 */
	const TBL_PROFILE_Y = 'y';

	/**
	 * @var string 是否生成扩展表：否
	 */
	const TBL_PROFILE_N = 'n';

	/**
	 * @var string 表引擎：MyISAM
	 */
	const TBL_ENGINE_MYISAM = 'MyISAM';

	/**
	 * @var string 表引擎：InnoDB
	 */
	const TBL_ENGINE_INNODB = 'InnoDB';

	/**
	 * @var string 表编码：utf8
	 */
	const TBL_CHARSET_UTF8 = 'utf8';

	/**
	 * @var string 表编码：gbk
	 */
	const TBL_CHARSET_GBK = 'gbk';

	/**
	 * @var string 表编码：gb2312
	 */
	const TBL_CHARSET_GB2312 = 'gb2312';

	/**
	 * @var string 数据列表每行操作Btn：编辑
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
	 * @var string 是否删除：是
	 */
	const TRASH_Y = 'y';

	/**
	 * @var string 是否删除：否
	 */
	const TRASH_N = 'n';

	/**
	 * 获取“是否生成扩展表”所有选项
	 * @return array
	 */
	public static function getTblProfileEnums()
	{
		return array(
			self::TBL_PROFILE_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TBL_PROFILE_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“表引擎”所有选项
	 * @return array
	 */
	public static function getTblEngineEnums()
	{
		return array(
			self::TBL_ENGINE_MYISAM => Text::_('MOD_BUILDER_BUILDERS_ENUM_TBL_ENGINE_MYISAM'),
			self::TBL_ENGINE_INNODB => Text::_('MOD_BUILDER_BUILDERS_ENUM_TBL_ENGINE_INNODB'),
		);
	}

	/**
	 * 获取“表编码”所有选项
	 * @return array
	 */
	public static function getTblCharsetEnums()
	{
		return array(
			self::TBL_CHARSET_UTF8 => Text::_('MOD_BUILDER_BUILDERS_ENUM_TBL_CHARSET_UTF8'),
			self::TBL_CHARSET_GBK => Text::_('MOD_BUILDER_BUILDERS_ENUM_TBL_CHARSET_GBK'),
			self::TBL_CHARSET_GB2312 => Text::_('MOD_BUILDER_BUILDERS_ENUM_TBL_CHARSET_GB2312'),
		);
	}

	/**
	 * 获取“数据列表每行操作Btn”所有选项
	 * @return array
	 */
	public static function getIndexRowBtnsEnums()
	{
		return array(
			self::INDEX_ROW_BTNS_PENCIL => Text::_('CFG_SYSTEM_GLOBAL_MODIFY'),
			self::INDEX_ROW_BTNS_TRASH => Text::_('CFG_SYSTEM_GLOBAL_TRASH'),
			self::INDEX_ROW_BTNS_REMOVE => Text::_('CFG_SYSTEM_GLOBAL_REMOVE'),
		);
	}

	/**
	 * 获取“是否删除”所有选项
	 * @return array
	 */
	public static function getTrashEnums()
	{
		return array(
			self::TRASH_Y => Text::_('CFG_SYSTEM_GLOBAL_YES'),
			self::TRASH_N => Text::_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“生成代码名”验证规则
	 * @return array
	 */
	public static function getBuilderNameRules()
	{
		return array(
			'MinLength' => array(6, Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_MINLENGTH')),
			'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“表名”验证规则
	 * @return array
	 */
	public static function getTblNameRules()
	{
		return array(
			'AlphaNum' => array(true, Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_ALPHANUM')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_MINLENGTH')),
			'MaxLength' => array(30, Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“是否生成扩展表”验证规则
	 * @return array
	 */
	public static function getTblProfileRules()
	{
		$enums = self::getTblProfileEnums();
		return array(
			'InArray' => array(
				array_keys($enums),
				sprintf(Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_INARRAY'), implode(', ', $enums))
			),
		);
	}

	/**
	 * 获取“表引擎”验证规则
	 * @return array
	 */
	public static function getTblEngineRules()
	{
		$enums = self::getTblEngineEnums();
		return array(
			'InArray' => array(
				array_keys($enums),
				sprintf(Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_INARRAY'), implode(', ', $enums))
			),
		);
	}

	/**
	 * 获取“表编码”验证规则
	 * @return array
	 */
	public static function getTblCharsetRules()
	{
		$enums = self::getTblCharsetEnums();
		return array(
			'InArray' => array(
				array_keys($enums),
				sprintf(Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_INARRAY'), implode(', ', $enums))
			),
		);
	}

	/**
	 * 获取“表描述”验证规则
	 * @return array
	 */
	public static function getTblCommentRules()
	{
		return array(
			'NotEmpty' => array(true, Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_NOTEMPTY')),
		);
	}

	/**
	 * 获取“应用名”验证规则
	 * @return array
	 */
	public static function getAppNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_APP_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_APP_NAME_MINLENGTH')),
			'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDERS_APP_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“模块名”验证规则
	 * @return array
	 */
	public static function getModNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_MINLENGTH')),
			'MaxLength' => array(50, Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“控制器名，默认和省略前缀的表名相同”验证规则
	 * @return array
	 */
	public static function getCtrlNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“类名，默认和省略前缀的表名相同”验证规则
	 * @return array
	 */
	public static function getClsNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-数据列表”验证规则
	 * @return array
	 */
	public static function getActIndexNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-数据详情”验证规则
	 * @return array
	 */
	public static function getActViewNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-新增数据”验证规则
	 * @return array
	 */
	public static function getActCreateNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-编辑数据”验证规则
	 * @return array
	 */
	public static function getActModifyNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-删除数据”验证规则
	 * @return array
	 */
	public static function getActRemoveNameRules()
	{
		return array(
			'Alpha' => array(true, Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_ALPHA')),
			'MinLength' => array(2, Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_MINLENGTH')),
			'MaxLength' => array(12, Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“数据列表每行操作Btn，编辑：pencil、放入回收站：trash、彻底删除：remove”验证规则
	 * @return array
	 */
	public static function getIndexRowBtnsRules()
	{
		$enums = self::getIndexRowBtnsEnums();
		return array(
			'InArray' => array(
				array_keys($enums),
				sprintf(Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_INARRAY'), implode(', ', $enums))
			),
		);
	}

	/**
	 * 获取“是否删除”验证规则
	 * @return array
	 */
	public static function getTrashRules()
	{
		$enums = self::getTrashEnums();
		return array(
			'InArray' => array(
				array_keys($enums),
				sprintf(Text::_('MOD_BUILDER_BUILDERS_TRASH_INARRAY'), implode(', ', $enums))
			),
		);
	}
}
