<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model;

use library\BaseModel;
use tfc\saf\Text;
use builders\services\DataBuilders;
use library\Constant;

/**
 * Builders class file
 * 生成代码
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builders.php 1 2014-05-26 19:25:19Z Code Generator $
 * @package modules.builder.model
 * @since 1.0
 */
class Builders extends BaseModel
{
	/**
	 * @var string 业务层名
	 */
	protected $_srvName = Constant::SRV_NAME_BUILDERS;

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
				'value' => DataBuilders::TBL_PROFILE_Y,
			),
			'tbl_engine' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_HINT'),
				'options' => DataBuilders::getTblEngineEnum(),
				'value' => DataBuilders::TBL_ENGINE_MYISAM,
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
			'srv_type' => array(
				'__tid__' => 'main',
				'type' => 'radio',
				'label' => Text::_('MOD_BUILDER_BUILDERS_SRV_TYPE_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_SRV_TYPE_HINT'),
				'options' => DataBuilders::getSrvTypeEnum(),
				'value' => DataBuilders::SRV_TYPE_DYNAMIC,
			),
			'srv_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_SRV_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_SRV_NAME_HINT'),
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
			'cls_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_HINT'),
				'required' => true,
			),
			'ctrl_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_HINT'),
				'required' => true,
			),
			'fk_column' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_FK_COLUMN_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_FK_COLUMN_HINT'),
				'required' => true,
			),
			'act_index_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_HINT'),
				'required' => true,
			),
			'act_view_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_HINT'),
				'required' => true,
			),
			'act_create_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_HINT'),
				'required' => true,
			),
			'act_modify_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_HINT'),
				'required' => true,
			),
			'act_remove_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_HINT'),
				'required' => true,
			),
			'index_row_btns' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_HINT'),
				'required' => true,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_HINT'),
				'required' => true,
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
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_HINT'),
				'required' => true,
			),
			'dt_modified' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_HINT'),
				'required' => true,
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
				'hint' => Text::_('MOD_BUILDER_BUILDERS_TRASH_HINT'),
				'options' => DataBuilders::getTrashEnum(),
				'value' => DataBuilders::TRASH_Y,
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
}
