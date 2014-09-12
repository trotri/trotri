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
use libapp\Model;
use posts\services\DataCategories;

/**
 * Categories class file
 * 类别管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Categories.php 1 2014-09-12 17:33:45Z Code Generator $
 * @package modules.posts.model
 * @since 1.0
 */
class Categories extends BaseModel
{
	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'htmlcache' => array(
				'tid' => 'htmlcache',
				'prompt' => Text::_('MOD_POSTS_POST_CATEGORIES_VIEWTAB_HTMLCACHE_PROMPT')
			),
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
			'category_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_CATEGORY_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_CATEGORY_ID_HINT'),
			),
			'category_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_CATEGORY_NAME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_CATEGORY_NAME_HINT'),
				'required' => true,
			),
			'category_pid' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_CATEGORY_PID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_CATEGORY_PID_HINT'),
				'required' => true,
			),
			'module_id' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_MODULE_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_MODULE_ID_HINT'),
				'required' => true,
			),
			'meta_title' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_META_TITLE_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_META_TITLE_HINT'),
				'required' => true,
			),
			'meta_keywords' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_META_KEYWORDS_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_META_KEYWORDS_HINT'),
				'required' => true,
			),
			'meta_description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_META_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_META_DESCRIPTION_HINT'),
				'required' => true,
			),
			'is_hide' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_IS_HIDE_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_IS_HIDE_HINT'),
				'options' => DataCategories::getIsHideEnum(),
				'value' => DataCategories::IS_HIDE_Y,
			),
			'menu_sort' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_MENU_SORT_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_MENU_SORT_HINT'),
				'required' => true,
			),
			'is_jump' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_IS_JUMP_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_IS_JUMP_HINT'),
				'options' => DataCategories::getIsJumpEnum(),
				'value' => DataCategories::IS_JUMP_Y,
			),
			'jump_url' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_JUMP_URL_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_JUMP_URL_HINT'),
				'required' => true,
			),
			'is_html' => array(
				'__tid__' => 'htmlcache',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_IS_HTML_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_IS_HTML_HINT'),
				'options' => DataCategories::getIsHtmlEnum(),
				'value' => DataCategories::IS_HTML_Y,
			),
			'html_dir' => array(
				'__tid__' => 'htmlcache',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_HTML_DIR_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_HTML_DIR_HINT'),
				'required' => true,
			),
			'tpl_home' => array(
				'__tid__' => 'htmlcache',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_TPL_HOME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_TPL_HOME_HINT'),
				'required' => true,
			),
			'tpl_list' => array(
				'__tid__' => 'htmlcache',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_TPL_LIST_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_TPL_LIST_HINT'),
				'required' => true,
			),
			'tpl_view' => array(
				'__tid__' => 'htmlcache',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_TPL_VIEW_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_TPL_VIEW_HINT'),
				'required' => true,
			),
			'rule_list' => array(
				'__tid__' => 'htmlcache',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_RULE_LIST_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_RULE_LIST_HINT'),
				'required' => true,
				'value' => 'list_{id}.html'
			),
			'rule_view' => array(
				'__tid__' => 'htmlcache',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POST_CATEGORIES_RULE_VIEW_LABEL'),
				'hint' => Text::_('MOD_POSTS_POST_CATEGORIES_RULE_VIEW_HINT'),
				'required' => true,
				'value' => '{y}/{m}/{d}/{id}.html'
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“类别名”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getCategoryNameLink($data)
	{
		$params = array(
			'id' => $data['category_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['category_name'], $url);
		return $output;
	}

	/**
	 * 递归方式获取所有的类别，默认用空格填充子类别左边用于和父类别错位（可用于Table列表）
	 * @param integer $categoryPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function findLists($categoryPid = 0, $padStr = '|—', $leftPad = '', $rightPad = null)
	{
		$ret = $this->callFetchMethod($this->getService(), 'findLists', array($categoryPid, $padStr, $leftPad, $rightPad));
		return $ret;
	}

	/**
	 * 递归方式获取所有的类别名，默认用空格填充子类别左边用于和父类别错位
	 * （只返回ID和类别名的键值对）（可用于Select表单的Option选项）
	 * @param integer $categoryPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function getOptions($categoryPid = 0, $padStr = '&nbsp;&nbsp;&nbsp;&nbsp;', $leftPad = '', $rightPad = null)
	{
		return $this->getService()->getOptions($categoryPid, $padStr, $leftPad, $rightPad);
	}

	/**
	 * 获取所有的ModuleName
	 * @return array
	 */
	public function getModuleNames()
	{
		return Model::getInstance('Modules')->getModuleNames();
	}

}
