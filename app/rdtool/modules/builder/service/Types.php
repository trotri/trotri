<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\service;

use library\BaseService;
use tfc\saf\Text;
use libsrv\SModFactory;
use libapp\PageHelper;
use builder\models\DataTypes;

/**
 * Types class file
 * 表单字段类型
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Types.php 1 2014-04-06 14:43:07Z huan.song $
 * @package modules.builder.service
 * @since 1.0
 */
class Types extends BaseService
{
	/**
	 * @var instance of builder\models\Types
	 */
	protected $_modTypes = null;

	/**
	 * 初始化业务层模型类
	 */
	public function _init()
	{
		$this->_modTypes = SModFactory::getInstance('Types', 'builder');
	}

	/**
	 * (non-PHPdoc)
	 * @see libapp.Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'type_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_ID_HINT'),
			),
			'type_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_TYPE_NAME_HINT'),
				'required' => true,
			),
			'form_type' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_FORM_TYPE_HINT'),
				'required' => true,
			),
			'field_type' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_FIELD_TYPE_HINT'),
				'required' => true,
			),
			'category' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_CATEGORY_HINT'),
				'options' => DataTypes::getCategoryEnum(),
				'value' => DataTypes::CATEGORY_TEXT,
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_TYPES_SORT_HINT'),
				'required' => true,
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“类型名，单行文本、多行文本、密码、开关选项卡、提交按钮等”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getTypeNameLink($data)
	{
		$params = array(
			'id' => $data['type_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['type_name'], $url);
		return $output;
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = null, $offset = null)
	{
		$ret = parent::search($this->_modTypes, array(), '', $limit, $offset);
		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		$ret = $this->callFetchMethod($this->_modTypes, 'findByPk', array($value));
		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$ret = $this->callCreateMethod($this->_modTypes, 'create', $params, $ignore);
		return $ret;
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $id
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($id, array $params = array())
	{
		$ret = $this->callModifyMethod($this->_modTypes, 'modifyByPk', $id, $params);
		return $ret;
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $id
	 * @return array
	 */
	public function removeByPk($id)
	{
		$ret = $this->callRemoveMethod($this->_modTypes, 'removeByPk', $id);
		return $ret;
	}
}
