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
use tfc\ap\Ap;
use tfc\ap\Registry;
use library\ErrorNo;
use library\GeneratorFactory;

/**
 * Validators class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Validators extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = GeneratorFactory::getDb('Validators');
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
		$fieldId = isset($params['field_id']) ? (int) $params['field_id'] : 0;

		$attributes = array();
		if ($fieldId > 0) {
			$attributes['field_id'] = $fieldId;
		}

		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
	}

	/**
	 * 获取field_id值
	 * @return integer
	 */
	public function getFieldId()
	{
		$fieldId = Ap::getRequest()->getInteger('field_id');
		if ($fieldId <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			$fieldId = $this->getFieldIdByValidatorId($id);
		}

		return $fieldId;
	}

	/**
	 * 通过validator_id获取field_id值
	 * @param integer $value
	 * @return string
	 */
	public function getFieldIdByValidatorId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('field_id', $value);
			$fieldId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['field_id'];
			Registry::set($name, $fieldId);
		}

		return Registry::get($name);
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
		$elements = GeneratorFactory::getElements('Validators');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'validator_name' => $elements->getValidatorName($type),
			'field_id' => $elements->getFieldId($type),
			'option_category' => $elements->getOptionCategory($type),
			'sort' => $elements->getSort($type),
			'when' => $elements->getWhen($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = GeneratorFactory::getElements('Validators');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'validator_name' => $elements->getValidatorName($type),
			'field_id' => $elements->getFieldId($type),
			'option_category' => $elements->getOptionCategory($type),
			'sort' => $elements->getSort($type),
			'when' => $elements->getWhen($type),
		);

		return $output;
	}
}
