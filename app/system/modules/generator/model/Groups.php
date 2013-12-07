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

use koala\Model;
use library\GeneratorFactory;

/**
 * Groups class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Groups extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = GeneratorFactory::getDb('Groups');
		parent::__construct($db);
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params)
	{
		return $this->insert($params);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $value
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($value, array $params)
	{
		return $this->updateByPk($value, $params);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = GeneratorFactory::getElements('Groups');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'group_name' => $elements->getGroupName($type),
			'generator_id' => $elements->getGeneratorId($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}
}
