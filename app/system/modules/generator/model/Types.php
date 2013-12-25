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
use tfc\ap\Registry;
use library\ErrorNo;
use library\GeneratorFactory;

/**
 * Types class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Types extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = GeneratorFactory::getDb('Types');
		parent::__construct($db);
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		$attributes = array();

		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
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
	 * 获取所有的Types值
	 * @return array
	 */
	public function getTypes()
	{
		$ret = $this->findPairsByAttributes(array('type_id', 'type_name'), array(), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			return array();
		}

		return $ret['data'];
	}

	/**
	 * 通过type_id获取type_name值
	 * @param integer $value
	 * @return string
	 */
	public function getTypeNameByTypeId($value)
	{
		$value = (int) $value;
		$name = 'Types::type_name_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('type_name', $value);
			$groupName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['type_name'];
			Registry::set($name, $groupName);
		}

		return Registry::get($name);
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
			'type_name' => $elements->getTypeName($type),
			'form_type' => $elements->getFormType($type),
			'field_type' => $elements->getFieldType($type),
			'category' => $elements->getCategory($type),
			'sort' => $elements->getSort($type),
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
			'type_name' => $elements->getTypeName($type),
			'form_type' => $elements->getFormType($type),
			'field_type' => $elements->getFieldType($type),
			'category' => $elements->getCategory($type),
			'sort' => $elements->getSort($type),
		);

		return $output;
	}
}
