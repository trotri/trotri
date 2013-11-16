<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\model;

use tfc\ap\UserIdentity;
use base\Model;
use library\Util;

/**
 * Generators class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Generators extends Model
{	
	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params)
	{
		$params['creator_id'] = UserIdentity::getId();
		$params['dt_created'] = Util::getNowTime();
		if (!isset($params['index_row_btns']) || !is_array($params['index_row_btns'])) {
			$params['index_row_btns'] = array();
		}

		return $this->insert($params, $this->getHelper());
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		$params['modifier_id'] = UserIdentity::getId();
		$params['dt_modified'] = Util::getNowTime();

		return $this->updateByPk($value, $params, $this->getHelper());
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $value
	 * @return array
	 */
	public function removeByPk($value)
	{
		return $this->deleteByPk($value);
	}

	/**
	 * (non-PHPdoc)
	 * @see library.Model::getDb()
	 */
	public function getDb()
	{
		return Util::getDb('Generators', 'generator');
	}
}
