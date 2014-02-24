<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace smods\builder;

use slib\BaseData;

/**
 * DataBuilders class file
 * 业务层：数据管理类，寄存常量、选项、验证规则
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataBuilders.php 1 2014-01-18 14:19:29Z huan.song $
 * @package smods.builder
 * @since 1.0
 */
class DataBuilders extends BaseData
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
	public function getTblProfileEnum()
	{
		return array(
			self::TBL_PROFILE_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::TBL_PROFILE_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“表引擎”所有选项
	 * @return array
	 */
	public function getTblEngineEnum()
	{
		return array(
			self::TBL_ENGINE_MYISAM => $this->_('MOD_BUILDER_BUILDERS_ENUM_TBL_ENGINE_MYISAM'),
			self::TBL_ENGINE_INNODB => $this->_('MOD_BUILDER_BUILDERS_ENUM_TBL_ENGINE_INNODB'),
		);
	}

	/**
	 * 获取“表编码”所有选项
	 * @return array
	 */
	public function getTblCharsetEnum()
	{
		return array(
			self::TBL_CHARSET_UTF8 => $this->_('MOD_BUILDER_BUILDERS_ENUM_TBL_CHARSET_UTF8'),
			self::TBL_CHARSET_GBK => $this->_('MOD_BUILDER_BUILDERS_ENUM_TBL_CHARSET_GBK'),
			self::TBL_CHARSET_GB2312 => $this->_('MOD_BUILDER_BUILDERS_ENUM_TBL_CHARSET_GB2312'),
		);
	}

	/**
	 * 获取“数据列表每行操作Btn”所有选项
	 * @return array
	 */
	public function getIndexRowBtnsEnum()
	{
		return array(
			self::INDEX_ROW_BTNS_PENCIL => $this->_('MOD_BUILDER_BUILDERS_ENUM_INDEX_ROW_BTNS_PENCIL'),
			self::INDEX_ROW_BTNS_TRASH => $this->_('MOD_BUILDER_BUILDERS_ENUM_INDEX_ROW_BTNS_TRASH'),
			self::INDEX_ROW_BTNS_REMOVE => $this->_('MOD_BUILDER_BUILDERS_ENUM_INDEX_ROW_BTNS_REMOVE'),
		);
	}

	/**
	 * 获取“是否删除”所有选项
	 * @return array
	 */
	public function getTrashEnum()
	{
		return array(
			self::TRASH_Y => $this->_('CFG_SYSTEM_GLOBAL_YES'),
			self::TRASH_N => $this->_('CFG_SYSTEM_GLOBAL_NO'),
		);
	}

	/**
	 * 获取“生成代码名”验证规则
	 * @return array
	 */
	public function getBuilderNameRule()
	{
		return array(
			'MinLength' => array(6, $this->_('MOD_BUILDER_BUILDERS_BUILDER_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_BUILDER_BUILDERS_BUILDER_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“表名”验证规则
	 * @return array
	 */
	public function getTblNameRule()
	{
		return array(
			'AlphaNum' => array(true, $this->_('MOD_BUILDER_BUILDERS_TBL_NAME_ALPHANUM')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_TBL_NAME_MINLENGTH')),
			'MaxLength' => array(30, $this->_('MOD_BUILDER_BUILDERS_TBL_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“是否生成扩展表”验证规则
	 * @return array
	 */
	public function getTblProfileRule()
	{
		$enum = $this->getTblProfileEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDERS_TBL_PROFILE_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“表引擎”验证规则
	 * @return array
	 */
	public function getTblEngineRule()
	{
		$enum = $this->getTblEngineEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDERS_TBL_ENGINE_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“表编码”验证规则
	 * @return array
	 */
	public function getTblCharsetRule()
	{
		$enum = $this->getTblCharsetEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDERS_TBL_CHARSET_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“表描述”验证规则
	 * @return array
	 */
	public function getTblCommentRule()
	{
		return array(
			'NotEmpty' => array(true, $this->_('MOD_BUILDER_BUILDERS_TBL_COMMENT_NOTEMPTY')),
		);
	}

	/**
	 * 获取“应用名”验证规则
	 * @return array
	 */
	public function getAppNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_APP_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_APP_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_BUILDER_BUILDERS_APP_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“模块名”验证规则
	 * @return array
	 */
	public function getModNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_MOD_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_MOD_NAME_MINLENGTH')),
			'MaxLength' => array(50, $this->_('MOD_BUILDER_BUILDERS_MOD_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“控制器名，默认和省略前缀的表名相同”验证规则
	 * @return array
	 */
	public function getCtrlNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_CTRL_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_CTRL_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_CTRL_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“类名，默认和省略前缀的表名相同”验证规则
	 * @return array
	 */
	public function getClsNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_CLS_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_CLS_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_CLS_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-数据列表”验证规则
	 * @return array
	 */
	public function getActIndexNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-数据详情”验证规则
	 * @return array
	 */
	public function getActViewNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-新增数据”验证规则
	 * @return array
	 */
	public function getActCreateNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-编辑数据”验证规则
	 * @return array
	 */
	public function getActModifyNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“行动名-删除数据”验证规则
	 * @return array
	 */
	public function getActRemoveNameRule()
	{
		return array(
			'Alpha' => array(true, $this->_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_ALPHA')),
			'MinLength' => array(2, $this->_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_MINLENGTH')),
			'MaxLength' => array(12, $this->_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“数据列表每行操作Btn，编辑：pencil、放入回收站：trash、彻底删除：remove”验证规则
	 * @return array
	 */
	public function getIndexRowBtnsRule()
	{
		$enum = $this->getIndexRowBtnsEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_INARRAY'), implode(', ', $enum))
			),
		);
	}

	/**
	 * 获取“是否删除”验证规则
	 * @return array
	 */
	public function getTrashRule()
	{
		$enum = $this->getTrashEnum();
		return array(
			'InArray' => array(
				array_keys($enum),
				sprintf($this->_('MOD_BUILDER_BUILDERS_TRASH_INARRAY'), implode(', ', $enum))
			),
		);
	}
}
