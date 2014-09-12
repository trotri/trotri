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

use libsrv\AbstractService;
use posts\db\Categories AS DbCategories;

/**
 * Categories class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Categories.php 1 2014-09-12 15:48:15Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class Categories extends AbstractService
{
	/**
	 * @var instance of posts\db\Categories
	 */
	protected $_dbCategories = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_dbCategories = new DbCategories();
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
		$rows = $this->_dbCategories->findAllByCategoryPid($categoryPid);
		if (!$rows || !is_array($rows)) {
			return array();
		}

		$tmpLeftPad = is_string($leftPad) ? $leftPad . $padStr : null;
		$tmpRightPad = is_string($rightPad) ? $rightPad . $padStr : null;

		$data = array();
		foreach ($rows as $row) {
			$row['category_name'] = $leftPad . $row['category_name'] . $rightPad;
			$data[] = $row;

			$tmpRows = $this->findLists($row['category_id'], $padStr, $tmpLeftPad, $tmpRightPad);
			$data = array_merge($data, $tmpRows);
		}

		return $data;
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
		$data = array();

		$rows = $this->findLists($categoryPid, $padStr, $leftPad, $rightPad);
		if (is_array($rows)) {
			foreach ($rows as $row) {
				if (!isset($row['category_id']) || !isset($row['category_name'])) {
					continue;
				}

				$groupId = (int) $row['category_id'];
				$data[$groupId] = $row['category_name'];
			}
		}

		return $data;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $categoryId
	 * @return array
	 */
	public function findByPk($categoryId)
	{
		$row = $this->_dbCategories->findByPk($categoryId);
		return $row;
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $categoryId
	 * @return mixed
	 */
	public function getByPk($columnName, $categoryId)
	{
		$value = $this->_dbCategories->getByPk($columnName, $categoryId);
		return $value;
	}

	/**
	 * 通过“主键ID”，获取“类别名”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getCategoryNameByCategoryId($categoryId)
	{
		$value = $this->getByPk('category_name', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“所属父类别”
	 * @param integer $categoryId
	 * @return integer
	 */
	public function getCategoryPidByCategoryId($categoryId)
	{
		$value = $this->getByPk('category_pid', $categoryId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“所属模型”
	 * @param integer $categoryId
	 * @return integer
	 */
	public function getModuleIdByCategoryId($categoryId)
	{
		$value = $this->getByPk('module_id', $categoryId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“SEO标题”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getMetaTitleByCategoryId($categoryId)
	{
		$value = $this->getByPk('meta_title', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“SEO关键字”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getMetaKeywordsByCategoryId($categoryId)
	{
		$value = $this->getByPk('meta_keywords', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“SEO描述”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getMetaDescriptionByCategoryId($categoryId)
	{
		$value = $this->getByPk('meta_description', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“菜单是否隐藏”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getIsHideByCategoryId($categoryId)
	{
		$value = $this->getByPk('is_hide', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“菜单排序”
	 * @param integer $categoryId
	 * @return integer
	 */
	public function getMenuSortByCategoryId($categoryId)
	{
		$value = $this->getByPk('menu_sort', $categoryId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“是否跳转”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getIsJumpByCategoryId($categoryId)
	{
		$value = $this->getByPk('is_jump', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“跳转链接”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getJumpUrlByCategoryId($categoryId)
	{
		$value = $this->getByPk('jump_url', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否生成静态页面”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getIsHtmlByCategoryId($categoryId)
	{
		$value = $this->getByPk('is_html', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“生成静态页面存放目录”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getHtmlDirByCategoryId($categoryId)
	{
		$value = $this->getByPk('html_dir', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“封页模板名”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getTplHomeByCategoryId($categoryId)
	{
		$value = $this->getByPk('tpl_home', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“列表模板名”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getTplListByCategoryId($categoryId)
	{
		$value = $this->getByPk('tpl_list', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“文档模板名”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getTplViewByCategoryId($categoryId)
	{
		$value = $this->getByPk('tpl_view', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“列表静态页面链接规则”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getRuleListByCategoryId($categoryId)
	{
		$value = $this->getByPk('rule_list', $categoryId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“文档静态页面链接规则”
	 * @param integer $categoryId
	 * @return string
	 */
	public function getRuleViewByCategoryId($categoryId)
	{
		$value = $this->getByPk('rule_view', $categoryId);
		return $value ? $value : '';
	}

}
