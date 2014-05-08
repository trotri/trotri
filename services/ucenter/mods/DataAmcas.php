<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace srv\user\mods;

use srv\library\Text;

/**
 * DataAmcas class file
 * 业务层：数据管理类，寄存常量、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: DataAmcas.php 1 2014-04-06 14:43:06Z huan.song $
 * @package srv.user.mods
 * @since 1.0
 */
class DataAmcas
{
	/**
	 * @var string 类型：app
	 */
	const CATEGORY_APP = 'app';

	/**
	 * @var string 类型：mod
	 */
	const CATEGORY_MOD = 'mod';

	/**
	 * @var string 类型：ctrl
	 */
	const CATEGORY_CTRL = 'ctrl';

	/**
	 * @var string 类型：act
	 */
	const CATEGORY_ACT = 'act';

	/**
	 * 获取“类型”所有选项
	 * @return array
	 */
	public static function getCategoryEnum()
	{
		static $enum = null;
		if ($enum === null) {
			$enum = array(
				self::CATEGORY_APP => Text::_('MOD_USER_USER_AMCAS_ENUM_CATEGORY_APP'),
				self::CATEGORY_MOD => Text::_('MOD_USER_USER_AMCAS_ENUM_CATEGORY_MOD'),
				self::CATEGORY_CTRL => Text::_('MOD_USER_USER_AMCAS_ENUM_CATEGORY_CTRL'),
				self::CATEGORY_ACT => Text::_('MOD_USER_USER_AMCAS_ENUM_CATEGORY_ACT'),
			);
		}

		return $enum;
	}

}
