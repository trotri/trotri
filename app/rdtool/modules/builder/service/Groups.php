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
use tfc\ap\Ap;
use tfc\saf\Text;
use libsrv\SModFactory;
use libapp\PageHelper;
use libapp\Service;

/**
 * Groups class file
 * 表单字段组
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Groups.php 1 2014-04-06 14:43:07Z huan.song $
 * @package modules.builder.service
 * @since 1.0
 */
class Groups extends BaseService
{
	/**
	 * @var instance of builder\models\Groups
	 */
	protected $_modGroups = null;

	/**
	 * @var instance of modules\builder\service\Builders
	 */
	protected $_srvBuilders = null;

	/**
	 * 初始化业务层模型类
	 */
	public function _init()
	{
		$this->_modGroups = SModFactory::getInstance('Groups', 'builder');
		$this->_srvBuilders = Service::getInstance('Builders', 'builder');
	}

	/**
	 * (non-PHPdoc)
	 * @see libapp.Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'group_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_ID_HINT'),
			),
			'group_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_GROUP_NAME_HINT'),
				'required' => true,
			),
			'prompt' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_PROMPT_HINT'),
				'required' => true,
			),
			'builder_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_BUILDER_ID_HINT'),
			),
			'builder_name' => array(
				'type' => 'string',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
			),
			'sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_SORT_HINT'),
				'required' => true,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDER_FIELD_GROUPS_DESCRIPTION_HINT'),
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“组名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getGroupNameLink($data)
	{
		$params = array(
			'id' => $data['group_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['group_name'], $url);
		return $output;
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
			$builderId = $this->_modGroups->getByPk('builder_id', $id);
		}

		return $builderId;
	}

	/**
	 * 获取列表页“生成代码名”选项
	 * @param integer $builderId
	 * @return string
	 */
	public function getBuilderNameByBuilderId($builderId)
	{
		$builderName = $this->_srvBuilders->getBuilderNameByBuilderId($builderId);
		return $builderName;
	}

	/**
	 * 查询数据
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = 'sort', $limit = null, $offset = null)
	{
		$builderId = isset($params['builder_id']) ? (int) $params['builder_id'] : 0;
		$params = array();
		if ($builderId >= 0) {
			$params['builder_id'] = $builderId;
		}

		$ret = parent::search($this->_modGroups, $params, $order, $limit, $offset);
		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		$ret = $this->callFetchMethod($this->_modGroups, 'findByPk', array($value));
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
		$ret = $this->callCreateMethod($this->_modGroups, 'create', $params, $ignore);
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
		$ret = $this->callModifyMethod($this->_modGroups, 'modifyByPk', $id, $params);
		return $ret;
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $id
	 * @return array
	 */
	public function removeByPk($id)
	{
		$ret = $this->callRemoveMethod($this->_modGroups, 'removeByPk', $id);
		return $ret;
	}

	/**
	 * 通过主键，删除多条记录。不支持联合主键
	 * @param array $ids
	 * @return array
	 */
	public function batchRemoveByPk(array $ids)
	{
		$ret = $this->callRemoveMethod($this->_modGroups, 'batchRemoveByPk', $ids);
		return $ret;
	}

	/**
	 * 通过主键，将一条记录移至回收站。不支持联合主键
	 * @param integer $id
	 * @return array
	 */
	public function trashByPk($id)
	{
		$ret = $this->callRemoveMethod($this->_modGroups, 'trashByPk', $id);
		return $ret;
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $ids
	 * @return array
	 */
	public function batchTrashByPk(array $ids)
	{
		$ret = $this->callRemoveMethod($this->_modGroups, 'batchTrashByPk', $ids);
		return $ret;
	}

	/**
	 * 通过主键，从回收站还原一条记录
	 * @param integer $pk
	 * @return integer
	 */
	public function restoreByPk($pk)
	{
		$ret = $this->callRestoreMethod($this->_modGroups, 'restoreByPk', $pk);
		return $ret;
	}

	/**
	 * 通过主键，将多条记录移至回收站。不支持联合主键
	 * @param array $ids
	 * @return integer
	 */
	public function batchRestoreByPk(array $ids)
	{
		$ret = $this->callRestoreMethod($this->_modGroups, 'batchRestoreByPk', $ids);
		return $ret;
	}
}
