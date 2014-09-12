<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\model;

use library\BaseModel;
use tfc\saf\Text;
use posts\services\DataModules;

/**
 * Modules class file
 * 模型管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modules.php 1 2014-09-11 18:41:37Z Code Generator $
 * @package modules.posts.model
 * @since 1.0
 */
class Modules extends BaseModel
{
	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'module_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_POSTS_POST_MODULES_MODULE_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_MODULES_MODULE_ID_HINT'),
			),
			'module_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_MODULES_MODULE_NAME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_MODULES_MODULE_NAME_HINT'),
				'required' => true,
			),
			'module_tblname' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_MODULES_MODULE_TBLNAME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_MODULES_MODULE_TBLNAME_HINT'),
				'required' => true,
			),
			'forbidden' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POST_MODULES_FORBIDDEN_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_MODULES_FORBIDDEN_HINT'),
				'options' => DataModules::getForbiddenEnum(),
				'value' => DataModules::FORBIDDEN_N,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_POSTS_POST_MODULES_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_MODULES_DESCRIPTION_HINT'),
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“模型名称”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getModuleNameLink($data)
	{
		$params = array(
			'id' => $data['module_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['module_name'], $url);
		return $output;
	}

	/**
	 * 查询数据列表
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = null, $offset = null)
	{
		$ret = parent::search($this->getService(), array(), '', $limit, $offset);
		return $ret;
	}

	/**
	 * 获取所有的ModuleName
	 * @return array
	 */
	public function getModuleNames()
	{
		return $this->getService()->getModuleNames();
	}

}
