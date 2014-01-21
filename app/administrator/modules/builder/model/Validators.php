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
use tfc\saf\Text;
use koala\Model;
use library\ErrorNo;
use library\BuilderFactory;

/**
 * Validators class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Validators.php 1 2014-01-20 15:58:15Z huan.song $
 * @package modules.builder.model
 * @since 1.0
 */
class Validators extends Model
{
	/**
	 * 构造方法：初始化当前业务类对应的数据库操作类
	 */
	public function __construct()
	{
		$db = BuilderFactory::getDb('Validators');
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
		$elements = BuilderFactory::getElements('Validators');
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
		$elements = BuilderFactory::getElements('Validators');
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
	 * @return integer
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
	 * 获取所有的验证类名
	 * @param boolean $default
	 * @return array
	 */
	public function getValidatorOptions($default = true)
	{
		$ret = array(
			'AlphaNum' => 'AlphaNum',
			'Alpha' => 'Alpha',
			'EqualTo' => 'EqualTo',
			'Equal' => 'Equal',
			'Float' => 'Float',
			'InArray' => 'InArray',
			'Integer' => 'Integer',
			'Ip' => 'Ip',
			'Mail' => 'Mail',
			'MaxLength' => 'MaxLength',
			'Max' => 'Max',
			'MinLength' => 'MinLength',
			'Min' => 'Min',
			'NotEmpty' => 'NotEmpty',
			'Numeric' => 'Numeric',
			'Require' => 'Require',
			'Url' => 'Url',
		);

		return $default ? $ret['Integer'] : $ret;
	}

	/**
	 * 获取所有的验证消息
	 * @param string $field
	 * @param string $option
	 * @return array
	 */
	public function getValidatorMessages($field, $option = '')
	{
		$ret = array(
			'AlphaNum' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_ALPHANUM_LABEL')),
			),
			'Alpha' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_ALPHA_LABEL')),
			),
			'EqualTo' => array(
				'option_category' => 'string',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_EQUALTO_LABEL')),
			),
			'Equal' => array(
				'option_category' => 'string',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_EQUAL_LABEL')),
			),
			'Float' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_FLOAT_LABEL')),
			),
			'InArray' => array(
				'option_category' => 'array',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_INARRAY_LABEL')),
			),
			'Integer' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_INTEGER_LABEL')),
			),
			'Ip' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_IP_LABEL')),
			),
			'Mail' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MAIL_LABEL')),
			),
			'MaxLength' => array(
				'option_category' => 'integer',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MAXLENGTH_LABEL')),
			),
			'Max' => array(
				'option_category' => 'integer',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MAX_LABEL')),
			),
			'MinLength' => array(
				'option_category' => 'integer',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MINLENGTH_LABEL')),
			),
			'Min' => array(
				'option_category' => 'integer',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_MIN_LABEL')),
			),
			'NotEmpty' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_NOTEMPTY_LABEL')),
			),
			'Numeric' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_NUMERIC_LABEL')),
			),
			'Require' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_REQUIRE_LABEL')),
			),
			'Url' => array(
				'option_category' => 'boolean',
				'message' => str_replace('{field}', $field, Text::_('MOD_BUILDER_BUILDER_FIELD_VALIDATORS_MESSAGE_URL_LABEL')),
			)
		);

		return isset($ret[$option]) ? $ret[$option] : $ret;
	}
}
