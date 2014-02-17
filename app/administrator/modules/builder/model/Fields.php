<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use tfc\ap\Ap;
use tfc\ap\Registry;
use koala\Model;
use library\ErrorNo;
use library\BuilderFactory;

/**
 * Fields class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Fields.php 1 2014-01-19 17:52:00Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Fields extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = BuilderFactory::getDb('Fields');
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
		$builderId = isset($params['builder_id']) ? (int) $params['builder_id'] : 0;

		$attributes = array();
		if ($builderId > 0) {
			$attributes['builder_id'] = $builderId;
		}

		$ret = $this->findIndexByAttributes($attributes, $order, $pageNo);
		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params = array())
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
		$elements = BuilderFactory::getElements('Fields');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'field_name' => $elements->getFieldName($type),
			'column_length' => $elements->getColumnLength($type),
			'column_auto_increment' => $elements->getColumnAutoIncrement($type),
			'column_unsigned' => $elements->getColumnUnsigned($type),
			'column_comment' => $elements->getColumnComment($type),
			'builder_id' => $elements->getBuilderId($type),
			'group_id' => $elements->getGroupId($type),
			'type_id' => $elements->getTypeId($type),
			'sort' => $elements->getSort($type),
			'html_label' => $elements->getHtmlLabel($type),
			'form_prompt' => $elements->getFormPrompt($type),
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
		$elements = BuilderFactory::getElements('Fields');
		$type = $elements::TYPE_FILTER;
		$output = array(
			'field_name' => $elements->getFieldName($type),
			'column_length' => $elements->getColumnLength($type),
			'column_auto_increment' => $elements->getColumnAutoIncrement($type),
			'column_unsigned' => $elements->getColumnUnsigned($type),
			'column_comment' => $elements->getColumnComment($type),
			'builder_id' => $elements->getBuilderId($type),
			'group_id' => $elements->getGroupId($type),
			'type_id' => $elements->getTypeId($type),
			'sort' => $elements->getSort($type),
			'html_label' => $elements->getHtmlLabel($type),
			'form_prompt' => $elements->getFormPrompt($type),
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
	 * @see koala.Model::getCleanRulesBeforeValidator()
	 */
	public function getCleanRulesBeforeValidator()
	{
		$output = array(
			'field_name' => array($this, 'cleanXss'),
			'column_length' => array($this, 'cleanXss'),
			'column_comment' => array($this, 'cleanXss'),
			'html_label' => array($this, 'cleanXss'),
			'form_prompt' => array($this, 'cleanXss')
		);

		return $output;
	}

	/**
	 * 通过field_id获取field_name值
	 * @param integer $value
	 * @return string
	 */
	public function getFieldNameByFieldId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('field_name', $value);
			$fieldName = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['field_name'];
			Registry::set($name, $fieldName);
		}

		return Registry::get($name);
	}

	/**
	 * 通过field_id获取html_label值
	 * @param integer $value
	 * @return string
	 */
	public function getHtmlLabelByFieldId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('html_label', $value);
			$htmlLabel = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? '' : $ret['html_label'];
			Registry::set($name, $htmlLabel);
		}

		return Registry::get($name);
	}

	/**
	 * 通过field_id获取builder_id值
	 * @param integer $value
	 * @return integer
	 */
	public function getBuilderIdByFieldId($value)
	{
		$value = (int) $value;
		$name = __METHOD__ . '_' . $value;
		if (!Registry::has($name)) {
			$ret = $this->getByPk('builder_id', $value);
			$builderId = ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) ? 0 : $ret['builder_id'];
			Registry::set($name, $builderId);
		}

		return Registry::get($name);
	}

	/**
	 * 获取builder_id值
	 * @return integer
	 */
	public function getBuilderId()
	{
		$builderId = Ap::getRequest()->getInteger('builder_id');
		if ($builderId <= 0) {
			$id = Ap::getRequest()->getInteger('id');
			$builderId = $this->getBuilderIdByFieldId($id);
		}

		return $builderId;
	}

	/**
	 * 通过field_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByFieldId($value)
	{
		$builderId = $this->getBuilderIdByFieldId($value);
		return BuilderFactory::getModel('Builders')->getBuilderNameByBuilderId($builderId);
	}

	/**
	 * 通过builder_id获取builder_name值
	 * @param integer $value
	 * @return string
	 */
	public function getBuilderNameByBuilderId($value)
	{
		return BuilderFactory::getModel('Builders')->getBuilderNameByBuilderId($value);
	}
}
