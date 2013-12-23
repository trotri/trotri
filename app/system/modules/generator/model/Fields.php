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
use library\Url;
use library\ErrorNo;
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
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $pageNo
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $pageNo = 0)
	{
		$generatorId = isset($params['generator_id']) ? (int) $params['generator_id'] : 0;

		$attributes = array();
		if ($generatorId > 0) {
			$attributes['generator_id'] = $generatorId;
		}

		Url::setHttpReturn($pageNo, $attributes);
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
	 * 通过field_id获取field_name值
	 * @param integer $value
	 * @return string
	 */
	public function getFieldNameByFieldId($value)
	{
		$value = (int) $value;
		$name = 'Fields::field_name_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('field_name', $value);
			$fieldName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['field_name'];
			Registry::set($name, $fieldName);
		}

		return Registry::get($name);
	}

	/**
	 * 通过field_id获取generator_name值
	 * @param integer $value
	 * @return string
	 */
	public function getGeneratorNameByFieldId($value)
	{
		$generatorId = $this->getGeneratorIdByFieldId($value);
		return GeneratorFactory::getModel('Generators')->getGeneratorNameByGeneratorId($generatorId);
	}

	/**
	 * 通过field_id获取generator_id值
	 * @param integer $value
	 * @return string
	 */
	public function getGeneratorIdByFieldId($value)
	{
		$value = (int) $value;
		$name = 'Fields::generator_id_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('generator_id', $value);
			$generatorId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['generator_id'];
			Registry::set($name, $generatorId);
		}

		return Registry::get($name);
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getInsertRules()
	 */
	public function getInsertRules()
	{
		$elements = GeneratorFactory::getElements('Fields');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'field_name' => $elements->getFieldName($type),
			'column_length' => $elements->getColumnLength($type),
			'column_auto_increment' => $elements->getColumnAutoIncrement($type),
			'column_unsigned' => $elements->getColumnUnsigned($type),
			'column_comment' => $elements->getColumnComment($type),
			'group_id' => $elements->getGroupId($type),
			'generator_id' => $elements->getGeneratorId($type),
			'type_id' => $elements->getTypeId($type),
			'sort' => $elements->getSort($type),
			'html_label' => $elements->getHtmlLabel($type),
			'form_required' => $elements->getFormRequired($type),
			'form_modifiable' => $elements->getFormModifiable($type),
			'index_show' => $elements->getIndexShow($type),
			'index_sort' => $elements->getIndexSort($type),
			'form_create_show' => $elements->getFormCreateShow($type),
			'form_create_sort' => $elements->getFormCreateSort($type),
			'form_modify_show' => $elements->getFormModifyShow($type),
			'form_modify_sort' => $elements->getFormModifySort($type),
			'form_search_show' => $elements->getFormSearchShow($type),
			'form_search_sort' => $elements->getFormSearchSort($type),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see koala.Model::getUpdateRules()
	 */
	public function getUpdateRules()
	{
		$elements = GeneratorFactory::getElements('Fields');
		$type = $elements::TYPE_FILTER;

		$output = array(
			'field_name' => $elements->getFieldName($type),
			'column_length' => $elements->getColumnLength($type),
			'column_auto_increment' => $elements->getColumnAutoIncrement($type),
			'column_unsigned' => $elements->getColumnUnsigned($type),
			'column_comment' => $elements->getColumnComment($type),
			'group_id' => $elements->getGroupId($type),
			'generator_id' => $elements->getGeneratorId($type),
			'type_id' => $elements->getTypeId($type),
			'sort' => $elements->getSort($type),
			'html_label' => $elements->getHtmlLabel($type),
			'form_required' => $elements->getFormRequired($type),
			'form_modifiable' => $elements->getFormModifiable($type),
			'index_show' => $elements->getIndexShow($type),
			'index_sort' => $elements->getIndexSort($type),
			'form_create_show' => $elements->getFormCreateShow($type),
			'form_create_sort' => $elements->getFormCreateSort($type),
			'form_modify_show' => $elements->getFormModifyShow($type),
			'form_modify_sort' => $elements->getFormModifySort($type),
			'form_search_show' => $elements->getFormSearchShow($type),
			'form_search_sort' => $elements->getFormSearchSort($type),
		);

		return $output;
	}
}
