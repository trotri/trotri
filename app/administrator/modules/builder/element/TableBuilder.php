<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\element;

use tfc\mvc\Mvc;
use tfc\saf\Text;

/**
 * TableBuilder class file
 * 生成代码-列表页数据配置类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: TableBuilder.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.elements
 * @since 1.0
 */
class TableBuilder
{
	/**
	 * 获取所有的列表页元素
	 * @return array
	 */
	public function getElements()
	{
		return array(
			'builder_id' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_ID_LABEL'),
			),
			'builder_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_BUILDER_NAME_LABEL'),
				'callback' => array($this, 'getBuilderNameUrl')
			),
			'tbl_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_NAME_LABEL'),
			),
			'tbl_profile' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_PROFILE_LABEL'),
				'callback' => array($this, 'getTblProfileLabel')
			),
			'tbl_engine' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_ENGINE_LABEL'),
			),
			'tbl_charset' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_CHARSET_LABEL'),
			),
			'tbl_comment' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TBL_COMMENT_LABEL'),
			),
			'app_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_APP_NAME_LABEL'),
			),
			'mod_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_MOD_NAME_LABEL'),
			),
			'ctrl_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_CTRL_NAME_LABEL'),
			),
			'cls_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_CLS_NAME_LABEL'),
			),
			'act_index_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_INDEX_NAME_LABEL'),
			),
			'act_view_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_VIEW_NAME_LABEL'),
			),
			'act_create_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_CREATE_NAME_LABEL'),
			),
			'act_modify_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_MODIFY_NAME_LABEL'),
			),
			'act_remove_name' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_ACT_REMOVE_NAME_LABEL'),
			),
			'index_row_btns' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_INDEX_ROW_BTNS_LABEL'),
			),
			'description' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_DESCRIPTION_LABEL'),
			),
			'dt_created' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_CREATED_LABEL'),
			),
			'dt_modified' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_DT_MODIFIED_LABEL'),
			),
			'trash' => array(
				'label' => Text::_('MOD_BUILDER_BUILDERS_TRASH_LABEL'),
			),
		);
	}

	/**
	 * 获取列表页“生成代码名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getBuilderNameUrl($data)
	{
		$params = array('id' => $data['builder_id']);
		$url = Mvc::getView()->getUrlManager()->getUrl('modify', Mvc::$controller, Mvc::$module, $params);
		$ret = Mvc::getView()->getHtml()->a($data['builder_name'], $url);
		return $ret;
	}

	/**
	 * 获取列表页“是否生成扩展表”的选项
	 * @param array $data
	 * @return string
	 */
	public function getTblProfileLabel($data)
	{
		if ($data['trash'] === 'y') {
			$elements = BuilderFactory::getElements('Builders');
			$tblProfiles = $elements->getTblProfile($elements::TYPE_OPTIONS);
			return $tblProfiles[$data['tbl_profile']];
		}

		$params = array(
			'id' => $data['builder_id'],
			'column_name' => 'tbl_profile'
		);

		$url = Mvc::getView()->getUrlManager()->getUrl('singlemodify', Mvc::$controller, Mvc::$module, $params);
		$ret = Components::getSwitch($data['builder_id'], 'tbl_profile', $data['tbl_profile'], $modifyUrl);
		return $ret;
	}
}
