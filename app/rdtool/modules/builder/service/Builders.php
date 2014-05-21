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
use builder\models\DataBuilders;

/**
 * Builders class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-04-06 14:43:07Z huan.song $
 * @package modules.builder.service
 * @since 1.0
 */
class Builders extends BaseService
{
	/**
	 * @var instance of builder\models\Types
	 */
	protected $_modBuilders = null;

	/**
	 * 初始化业务层模型类
	 */
	public function _init()
	{
		$this->_modBuilders = SModFactory::getInstance('Builders', 'builder');
	}

	/**
	 * (non-PHPdoc)
	 * @see libapp.Elements::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'act' => array(
				'tid' => 'act',
				'prompt' => Text::_('MOD_BUILDER_BUILDERS_VIEWTAB_ACT_PROMPT')
			),
			'system' => array(
				'tid' => 'system',
				'prompt' => Text::_('MOD_BUILDER_BUILDERS_VIEWTAB_SYSTEM_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see libapp.Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$output = array(
			'builder_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_HINT'),
			),
			'builder_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_HINT'),
				'required' => true,
			),
			'tbl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_HINT'),
				'required' => true,
			),
			'tbl_profile' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_HINT'),
				'options' => DataBuilders::getTblProfileEnum(),
				'value' => DataBuilders::TBL_PROFILE_N,
			),
			'tbl_engine' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_HINT'),
				'options' => DataBuilders::getTblEngineEnum(),
				'value' => DataBuilders::TBL_ENGINE_INNODB,
			),
			'tbl_charset' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_HINT'),
				'options' => DataBuilders::getTblCharsetEnum(),
				'value' => DataBuilders::TBL_CHARSET_UTF8,
			),
			'tbl_comment' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_HINT'),
				'required' => true,
			),
			'app_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_HINT'),
				'required' => true,
			),
			'mod_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_HINT'),
				'required' => true,
			),
			'ctrl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_HINT'),
				'required' => true,
			),
			'cls_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_HINT'),
				'required' => true,
			),
			'fk_column' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_FK_COLUMN_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_FK_COLUMN_HINT'),
			),
			'act_index_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_HINT'),
				'value' => 'index',
				'required' => true,
			),
			'act_view_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_HINT'),
				'value' => 'view',
				'required' => true,
			),
			'act_create_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_HINT'),
				'value' => 'create',
				'required' => true,
			),
			'act_modify_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_HINT'),
				'value' => 'modify',
				'required' => true,
			),
			'act_remove_name' => array(
				'__tid__' => 'act',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_HINT'),
				'value' => 'remove',
				'required' => true,
			),
			'index_row_btns' => array(
				'__tid__' => 'main',
				'type' => 'checkbox',
				'label' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_HINT'),
				'options' => DataBuilders::getIndexRowBtnsEnum(),
				'value' => DataBuilders::INDEX_ROW_BTNS_PENCIL,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_HINT'),
			),
			'author_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_NAME_HINT'),
				'required' => true,
			),
			'author_mail' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_MAIL_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_AUTHOR_MAIL_HINT'),
				'required' => true,
			),
			'dt_created' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_HINT'),
				'disabled' => true,
			),
			'dt_modified' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_HINT'),
				'disabled' => true,
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TRASH_HINT'),
				'options' => DataBuilders::getTblCharsetEnum(),
				'value' => DataBuilders::TRASH_N,
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“生成代码名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getBuilderNameLink($data)
	{
		$params = array(
			'id' => $data['builder_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['builder_name'], $url);
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
		$ret = parent::search($this->_modBuilders, array(), '', $limit, $offset);
		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $value
	 * @return array
	 */
	public function findByPk($value)
	{
		$ret = $this->callFetchMethod($this->_modBuilders, 'findByPk', array($value));
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
		$ret = $this->callCreateMethod($this->_modBuilders, 'create', $params, $ignore);
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
		$ret = $this->callModifyMethod($this->_modBuilders, 'modifyByPk', $id, $params);
		return $ret;
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $id
	 * @return array
	 */
	public function removeByPk($id)
	{
		$ret = $this->callRemoveMethod($this->_modBuilders, 'removeByPk', $id);
		return $ret;
	}
}
