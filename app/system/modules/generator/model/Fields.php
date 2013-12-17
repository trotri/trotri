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
 * Fields class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Fields extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = GeneratorFactory::getDb('Fields');
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
		$elements = GeneratorFactory::getElements('Types');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'field_name' => $elements->getFieldName($type),
			'column_length' => $elements->getColumnLength($type),
			'column_auto_increment' => $elements->getColumnAutoIncrement($type),
			'column_unsigned' => $elements->getColumnUnsigned($type),
			'column_comment' => $elements->getColumnComment($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = GeneratorFactory::getElements('Types');
		$type = $elements::TYPE_FILTER;

		$output = array(
			
		);

		return $output;
	}
}
