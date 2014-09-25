<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\services;

use libsrv\FormProcessor;
use tfc\validator;
use posts\library\Lang;
use posts\library\TableNames;

/**
 * FpCategories class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpCategories.php 1 2014-09-12 15:48:15Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class FpCategories extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_process()
	 */
	protected function _process(array $params = array())
	{
		if ($this->isInsert()) {
			if (!$this->required($params,
				'category_name', 'category_pid', 'module_id', 'meta_title', 'meta_keywords', 'meta_description',
				'is_hide', 'menu_sort', 'is_jump', 'jump_url', 'is_html', 'html_dir',
				'tpl_home', 'tpl_list', 'tpl_view', 'rule_list', 'rule_view')) {
				return false;
			}
		}

		$this->isValids($params,
			'category_name', 'category_pid', 'module_id', 'meta_title', 'meta_keywords', 'meta_description',
			'is_hide', 'menu_sort', 'is_jump', 'jump_url', 'is_html', 'html_dir',
			'tpl_home', 'tpl_list', 'tpl_view', 'rule_list', 'rule_view');
		return !$this->hasError();
	}

	/**
	 * (non-PHPdoc)
	 * @see \libsrv\FormProcessor::_cleanPreProcess()
	 */
	protected function _cleanPreProcess(array $params)
	{
		$rules = array(
			'builder_name' => 'trim',
			'category_name' => 'trim',
			'category_pid' => 'intval',
			'module_id' => 'intval',
			'meta_title' => 'trim',
			'meta_keywords' => 'trim',
			'meta_description' => 'trim',
			'is_hide' => 'trim',
			'menu_sort' => 'intval',
			'is_jump' => 'trim',
			'jump_url' => 'trim',
			'is_html' => 'trim',
			'html_dir' => 'trim',
			'tpl_home' => 'trim',
			'tpl_list' => 'trim',
			'tpl_view' => 'trim',
			'rule_list' => 'trim',
			'rule_view' => 'trim',
		);

		$ret = $this->clean($rules, $params);
		return $ret;
	}

	/**
	 * 获取“类别名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getCategoryNameRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POST_CATEGORIES_CATEGORY_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 20, Lang::_('SRV_FILTER_POST_CATEGORIES_CATEGORY_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“所属父类别”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getCategoryPidRule($value)
	{
		if ($value === 0) {
			return array();
		}

		return array(
			'DbExists' => new validator\DbExistsValidator($value, true, Lang::_('SRV_FILTER_POST_CATEGORIES_CATEGORY_PID_EXISTS'), $this->getDbProxy(), TableNames::getCategories(), 'category_id')
		);
	}

	/**
	 * 获取“所属模型”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getModuleIdRule($value)
	{
		return array(
			'DbExists' => new validator\DbExistsValidator($value, true, Lang::_('SRV_FILTER_POST_CATEGORIES_MODULE_ID_EXISTS'), $this->getDbProxy(), TableNames::getModules(), 'module_id')
		);
	}

	/**
	 * 获取“SEO标题”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getMetaTitleRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POST_CATEGORIES_META_TITLE_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_META_TITLE_MAXLENGTH')),
		);
	}

	/**
	 * 获取“SEO关键字”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getMetaKeywordsRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POST_CATEGORIES_META_KEYWORDS_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_META_KEYWORDS_MAXLENGTH')),
		);
	}

	/**
	 * 获取“SEO描述”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getMetaDescriptionRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_POST_CATEGORIES_META_DESCRIPTION_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 120, Lang::_('SRV_FILTER_POST_CATEGORIES_META_DESCRIPTION_MAXLENGTH')),
		);
	}

	/**
	 * 获取“菜单是否隐藏”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsHideRule($value)
	{
		$enum = DataCategories::getIsHideEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POST_CATEGORIES_IS_HIDE_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“菜单排序”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getMenuSortRule($value)
	{
		return array(
			'Integer' => new validator\IntegerValidator($value, true, Lang::_('SRV_FILTER_POST_CATEGORIES_MENU_SORT_INTEGER')),
		);
	}

	/**
	 * 获取“是否跳转”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsJumpRule($value)
	{
		$enum = DataCategories::getIsJumpEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POST_CATEGORIES_IS_JUMP_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“跳转链接”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getJumpUrlRule($value)
	{
		if ($this->is_jump === DataCategories::IS_JUMP_N) { return array(); }

		return array(
			'Url' => new validator\UrlValidator($value, true, Lang::_('SRV_FILTER_POST_CATEGORIES_JUMP_URL_URL')),
		);
	}

	/**
	 * 获取“是否生成静态页面”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIsHtmlRule($value)
	{
		$enum = DataCategories::getIsHtmlEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_POST_CATEGORIES_IS_HTML_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“生成静态页面存放目录”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getHtmlDirRule($value)
	{
		return array(
			'AlphaNum' => new validator\AlphaNumValidator($value, true, Lang::_('SRV_FILTER_POST_CATEGORIES_HTML_DIR_ALPHANUM')),
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POST_CATEGORIES_HTML_DIR_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 20, Lang::_('SRV_FILTER_POST_CATEGORIES_HTML_DIR_MAXLENGTH')),
		);
	}

	/**
	 * 获取“封页模板名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTplHomeRule($value)
	{
		return array(
			'Regex' => new validator\RegexValidator($value, '/^[\w\.\/]+$/i', Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_HOME_REGEX')),
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_HOME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_HOME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“列表模板名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTplListRule($value)
	{
		return array(
			'Regex' => new validator\RegexValidator($value, '/^[\w\.\/]+$/i', Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_LIST_REGEX')),
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_LIST_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_LIST_MAXLENGTH')),
		);
	}

	/**
	 * 获取“文档模板名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTplViewRule($value)
	{
		return array(
			'Regex' => new validator\RegexValidator($value, '/^[\w\.\/]+$/i', Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_VIEW_REGEX')),
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_VIEW_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_TPL_VIEW_MAXLENGTH')),
		);
	}

	/**
	 * 获取“列表静态页面链接规则”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getRuleListRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POST_CATEGORIES_RULE_LIST_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_RULE_LIST_MAXLENGTH')),
		);
	}

	/**
	 * 获取“文档静态页面链接规则”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getRuleViewRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 1, Lang::_('SRV_FILTER_POST_CATEGORIES_RULE_VIEW_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_POST_CATEGORIES_RULE_VIEW_MAXLENGTH')),
		);
	}

}
