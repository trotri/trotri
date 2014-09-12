<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\db;

use tdo\AbstractDb;
use posts\library\Constant;
use posts\library\TableNames;

/**
 * Categories class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Categories.php 1 2014-09-12 16:11:25Z Code Generator $
 * @package posts.db
 * @since 1.0
 */
class Categories extends AbstractDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

	/**
	 * 通过父ID，获取所有的类别
	 * @param integer $categoryPid
	 * @return array
	 */
	public function findAllByCategoryPid($categoryPid)
	{
		if (($categoryPid = (int) $categoryPid) < 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getCategories();
		$sql = 'SELECT `category_id`, `category_name`, `category_pid`, `module_id`, `meta_title`, `meta_keywords`, `meta_description`, `is_hide`, `menu_sort`, `is_jump`, `jump_url`, `is_html`, `html_dir`, `tpl_home`, `tpl_list`, `tpl_view`, `rule_list`, `rule_view` FROM `' . $tableName . '` WHERE `category_pid` = ? ORDER BY `menu_sort`';
		return $this->fetchAll($sql, $categoryPid);
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $categoryId
	 * @return array
	 */
	public function findByPk($categoryId)
	{
		if (($categoryId = (int) $categoryId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getCategories();
		$sql = 'SELECT `category_id`, `category_name`, `category_pid`, `module_id`, `meta_title`, `meta_keywords`, `meta_description`, `is_hide`, `menu_sort`, `is_jump`, `jump_url`, `is_html`, `html_dir`, `tpl_home`, `tpl_list`, `tpl_view`, `rule_list`, `rule_view` FROM `' . $tableName . '` WHERE `category_id` = ?';
		return $this->fetchAssoc($sql, $categoryId);
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $categoryId
	 * @return mixed
	 */
	public function getByPk($columnName, $categoryId)
	{
		$row = $this->findByPk($categoryId);
		if ($row && is_array($row) && isset($row[$columnName])) {
			return $row[$columnName];
		}

		return false;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return integer
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$categoryName = isset($params['category_name']) ? trim($params['category_name']) : '';
		$categoryPid = isset($params['category_pid']) ? (int) $params['category_pid'] : 0;
		$moduleId = isset($params['module_id']) ? (int) $params['module_id'] : 0;
		$metaTitle = isset($params['meta_title']) ? trim($params['meta_title']) : '';
		$metaKeywords = isset($params['meta_keywords']) ? trim($params['meta_keywords']) : '';
		$metaDescription = isset($params['meta_description']) ? trim($params['meta_description']) : '';
		$isHide = isset($params['is_hide']) ? trim($params['is_hide']) : '';
		$menuSort = isset($params['menu_sort']) ? (int) $params['menu_sort'] : 0;
		$isJump = isset($params['is_jump']) ? trim($params['is_jump']) : '';
		$jumpUrl = isset($params['jump_url']) ? trim($params['jump_url']) : '';
		$isHtml = isset($params['is_html']) ? trim($params['is_html']) : '';
		$htmlDir = isset($params['html_dir']) ? trim($params['html_dir']) : '';
		$tplHome = isset($params['tpl_home']) ? trim($params['tpl_home']) : '';
		$tplList = isset($params['tpl_list']) ? trim($params['tpl_list']) : '';
		$tplView = isset($params['tpl_view']) ? trim($params['tpl_view']) : '';
		$ruleList = isset($params['rule_list']) ? trim($params['rule_list']) : '';
		$ruleView = isset($params['rule_view']) ? trim($params['rule_view']) : '';

		if ($categoryName === '' || $categoryPid <= 0 || $moduleId <= 0 || $metaTitle === '' || $metaKeywords === '' || $metaDescription === ''
			|| $isHide === '' || $menuSort <= 0 || $isJump === '' || $jumpUrl === '' || $isHtml === '' || $htmlDir === ''
			|| $tplHome === '' || $tplList === '' || $tplView === '' || $ruleList === '' || $ruleView === '') {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getCategories();
		$attributes = array(
			'category_name' => $categoryName,
			'category_pid' => $categoryPid,
			'module_id' => $moduleId,
			'meta_title' => $metaTitle,
			'meta_keywords' => $metaKeywords,
			'meta_description' => $metaDescription,
			'is_hide' => $isHide,
			'menu_sort' => $menuSort,
			'is_jump' => $isJump,
			'jump_url' => $jumpUrl,
			'is_html' => $isHtml,
			'html_dir' => $htmlDir,
			'tpl_home' => $tplHome,
			'tpl_list' => $tplList,
			'tpl_view' => $tplView,
			'rule_list' => $ruleList,
			'rule_view' => $ruleView,
		);

		$sql = $this->getCommandBuilder()->createInsert($tableName, array_keys($attributes), $ignore);
		return $this->insert($sql, $attributes);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $categoryId
	 * @param array $params
	 * @return integer
	 */
	public function modifyByPk($categoryId, array $params = array())
	{
		if (($categoryId = (int) $categoryId) <= 0) {
			return false;
		}

		$attributes = array();

		if (isset($params['category_name'])) {
			$categoryName = trim($params['category_name']);
			if ($categoryName !== '') {
				$attributes['category_name'] = $categoryName;
			}
		}

		if (isset($params['category_pid'])) {
			$categoryPid = (int) $params['category_pid'];
			if ($categoryPid > 0) {
				$attributes['category_pid'] = $categoryPid;
			}
		}

		if (isset($params['module_id'])) {
			$moduleId = (int) $params['module_id'];
			if ($moduleId > 0) {
				$attributes['module_id'] = $moduleId;
			}
		}

		if (isset($params['meta_title'])) {
			$metaTitle = trim($params['meta_title']);
			if ($metaTitle !== '') {
				$attributes['meta_title'] = $metaTitle;
			}
		}

		if (isset($params['meta_keywords'])) {
			$metaKeywords = trim($params['meta_keywords']);
			if ($metaKeywords !== '') {
				$attributes['meta_keywords'] = $metaKeywords;
			}
		}

		if (isset($params['meta_description'])) {
			$metaDescription = trim($params['meta_description']);
			if ($metaDescription !== '') {
				$attributes['meta_description'] = $metaDescription;
			}
		}

		if (isset($params['is_hide'])) {
			$isHide = trim($params['is_hide']);
			if ($isHide !== '') {
				$attributes['is_hide'] = $isHide;
			}
		}

		if (isset($params['menu_sort'])) {
			$menuSort = (int) $params['menu_sort'];
			if ($menuSort > 0) {
				$attributes['menu_sort'] = $menuSort;
			}
		}

		if (isset($params['is_jump'])) {
			$isJump = trim($params['is_jump']);
			if ($isJump !== '') {
				$attributes['is_jump'] = $isJump;
			}
		}

		if (isset($params['jump_url'])) {
			$jumpUrl = trim($params['jump_url']);
			if ($jumpUrl !== '') {
				$attributes['jump_url'] = $jumpUrl;
			}
		}

		if (isset($params['is_html'])) {
			$isHtml = trim($params['is_html']);
			if ($isHtml !== '') {
				$attributes['is_html'] = $isHtml;
			}
		}

		if (isset($params['html_dir'])) {
			$htmlDir = trim($params['html_dir']);
			if ($htmlDir !== '') {
				$attributes['html_dir'] = $htmlDir;
			}
		}

		if (isset($params['tpl_home'])) {
			$tplHome = trim($params['tpl_home']);
			if ($tplHome !== '') {
				$attributes['tpl_home'] = $tplHome;
			}
		}

		if (isset($params['tpl_list'])) {
			$tplList = trim($params['tpl_list']);
			if ($tplList !== '') {
				$attributes['tpl_list'] = $tplList;
			}
		}

		if (isset($params['tpl_view'])) {
			$tplView = trim($params['tpl_view']);
			if ($tplView !== '') {
				$attributes['tpl_view'] = $tplView;
			}
		}

		if (isset($params['rule_list'])) {
			$ruleList = trim($params['rule_list']);
			if ($ruleList !== '') {
				$attributes['rule_list'] = $ruleList;
			}
		}

		if (isset($params['rule_view'])) {
			$ruleView = trim($params['rule_view']);
			if ($ruleView !== '') {
				$attributes['rule_view'] = $ruleView;
			}
		}

		if ($attributes === array()) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getCategories();
		$sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), '`category_id` = ?');
		$attributes['category_id'] = $categoryId;
		return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $categoryId
	 * @return integer
	 */
	public function removeByPk($categoryId)
	{
		if (($categoryId = (int) $categoryId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getCategories();
		$sql = $this->getCommandBuilder()->createDelete($tableName, '`category_id` = ?');
		return $this->delete($sql, $categoryId);
	}
}
