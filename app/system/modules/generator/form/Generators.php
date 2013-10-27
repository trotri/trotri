<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\form;

/**
 * Generators class file
 * 表单处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.form
 * @since 1.0
 */
class Generators
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
	 * @var array 数据库表引擎
	 */
	public static $tblEngines = array (
		self::TBL_ENGINE_INNODB,
		self::TBL_ENGINE_MYISAM
	);

	/**
	 * @var array 数据库表编码方式
	 */
	public static $tblCharsets = array (
		self::TBL_CHARSET_UTF8,
		self::TBL_CHARSET_GBK,
		self::TBL_CHARSET_GB2312
	);

	/**
	 * @var array 是否生成扩展表
	 */
	public static $tblProfiles = array (
		self::TBL_PROFILE_Y,
		self::TBL_PROFILE_N
	);

	/**
	 * @var array 是否删除
	 */
	public static $trashs = array (
		self::TRASH_Y,
		self::TRASH_N
	);

	/**
	 * @var array 数据列表每行操作Btn
	 */
	public static $indexRowBtns = array (
		self::INDEX_ROW_BTNS_PENCIL,
		self::INDEX_ROW_BTNS_TRASH,
		self::INDEX_ROW_BTNS_REMOVE
	);

	/**
	 * 获取生成代码名验证规则
	 * @return array
	 */
	public function getGeneratorNameRule()
	{	
		return array (
			'MinLength' => array (6, '生成代码名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '生成代码名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取表名验证规则
	 * @return array
	 */
	public function getTblNameRule()
	{
		return array (
			'AlphaNum' => array (true, '表名"%value%"只能由英文字母、数字或下划线组成.'),
			'MinLength' => array (2, '表名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '表名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取表引擎验证规则
	 * @return array
	 */
	public function getTblEngineRule()
	{
		return array (
			'InArray' => array (
				self::$tblEngines,
				'必须选择表引擎，值只能是' . implode('、', self::$tblEngines) . '.'
			),
		);
	}

	/**
	 * 获取表编码验证规则
	 * @return array
	 */
	public function getTblCharsetRule()
	{
		return array (
			'InArray' => array (
				self::$tblCharsets,
				'必须选择表编码，值只能是' . implode('、', self::$tblCharsets) . '.'
			),
		);
	}

	/**
	 * 获取表描述验证规则
	 * @return array
	 */
	public function getTblCommentRule()
	{
		return array (
			'NotEmpty' => array (true, '必须填写表描述.')
		);
	}

	/**
	 * 获取应用名验证规则
	 * @return array
	 */
	public function getAppNameRule()
	{
		return array (
			'Alpha' => array (true, '应用名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '应用名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '应用名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取模块名验证规则
	 * @return array
	 */
	public function getModNameRule()
	{
		return array (
			'Alpha' => array (true, '模块名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '模块名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '模块名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取控制器名验证规则
	 * @return array
	 */
	public function getCtrlNameRule()
	{
		return array (
			'Alpha' => array (true, '控制器名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '控制器名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '控制器名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取数据列表行动名验证规则
	 * @return array
	 */
	public function getActIndexNameRule()
	{
		return array (
			'Alpha' => array (true, '数据列表行动名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '数据列表行动名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '数据列表行动名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取数据详情行动名验证规则
	 * @return array
	 */
	public function getActViewNameRule()
	{
		return array (
			'Alpha' => array (true, '数据详情行动名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '数据详情行动名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '数据详情行动名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取新增数据行动名验证规则
	 * @return array
	 */
	public function getActCreateNameRule()
	{
		return array (
			'Alpha' => array (true, '新增数据行动名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '新增数据行动名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '新增数据行动名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取编辑数据行动名验证规则
	 * @return array
	 */
	public function getActModifyNameRule()
	{
		return array (
			'Alpha' => array (true, '编辑数据行动名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '编辑数据行动名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '编辑数据行动名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取编删除数据行动名验证规则
	 * @return array
	 */
	public function getActRemoveNameRule()
	{
		return array (
			'Alpha' => array (true, '删除数据行动名"%value%"只能由英文字母组成.'),
			'MinLength' => array (2, '删除数据行动名长度%value%不能小于%option%个字符.'),
			'MaxLength' => array (12, '删除数据行动名长度%value%不能大于%option%个字符.')
		);
	}

	/**
	 * 获取数据列表每行操作Btn验证规则
	 * @return array
	 */
	public function getIndexRowBtnsRule()
	{
		return array (
			'InArray' => array (
				self::$indexRowBtns,
				'数据列表每行操作Btn只能是' . implode('、', self::$indexRowBtns) . '.'
			),
		);
	}

	/**
	 * 获取是否生成扩展表验证规则
	 * @return array
	 */
	public function getTblProfileRule()
	{
		return array (
			'InArray' => array (
				self::$tblProfiles,
				'必须选择是否生成扩展表，值只能是' . implode('、', self::$tblProfiles) . '.'
			),
		);
	}

	/**
	 * 获取是否放入回收站验证规则
	 * @return array
	 */
	public function getTrashRule()
	{
		return array (
			'InArray' => array (
				self::$trashs,
				'必须选择是否放入回收站，值只能是' . implode('、', self::$trashs) . '.'
			),
		);
	}

	/**
	 * 获取所有的验证规则
	 * @return array
	 */
	public function getRules()
	{
		return array (
			'generator_name' => $this->getGeneratorNameRule(),
			'tbl_name' => $this->getTblNameRule(),
			'tbl_profile' => $this->getTblProfileRule(),
			'tbl_engine' => $this->getTblEngineRule(),
			'tbl_charset' => $this->getTblCharsetRule(),
			'tbl_comment' => $this->getTblCommentRule(),
			'app_name' => $this->getAppNameRule(),
			'mod_name' => $this->getModNameRule(),
			'ctrl_name' => $this->getCtrlNameRule(),
			'act_index_name' => $this->getActIndexNameRule(),
			'act_view_name' => $this->getActViewNameRule(),
			'act_create_name' => $this->getActCreateNameRule(),
			'act_modify_name' => $this->getActModifyNameRule(),
			'act_remove_name' => $this->getActRemoveNameRule(),
			'index_row_btns' => $this->getIndexRowBtnsRule(),
			'trash' => $this->getTrashRule()
		);
	}
}
